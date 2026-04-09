<?php
session_start();
include '../backend/ConnexionDB.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor' || !isset($_SESSION['doctor_id'])) {
    header("Location: ../login_signup/login-register.php");
    exit;
}

$db = ConnexionDB::getInstance();
$doctor_id = (int) $_SESSION['doctor_id'];
$success_msg = "";
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $specialization = trim($_POST['specialization']);
    $experience = trim($_POST['experience']);
    $consultation_fee = trim($_POST['consultation_fee']);
    $hospital = trim($_POST['hospital']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $about = trim($_POST['about']);
    
    $updateStmt = $db->prepare("UPDATE Doctor SET name = ?, specialization = ?, experience = ?, consultation_fee = ?, hospital = ?, phone = ?, email = ?, about = ? WHERE id = ?");
    if($updateStmt->execute([$name, $specialization, $experience, $consultation_fee, $hospital, $phone, $email, $about, $doctor_id])) {
        $success_msg = "Profile updated successfully!";
    } else {
        $error_msg = "Failed to update profile.";
    }
}

  $stmt = $db->prepare("SELECT id, name, email, phone, specialization, license_number, experience, consultation_fee, hospital, about, rating, reviews FROM Doctor WHERE id = ? LIMIT 1");
$stmt->execute([$doctor_id]);
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

$placeholderImage = "https://img.freepik.com/free-photo/female-doctor-hospital-with-stethoscope_23-2148827774.jpg";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>My Profile - HealthConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="view-profile.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="doctor-profile.css" />
  </head>
  <body>
    <header>
      <div class="logo">Health <span>Connect</span></div>
      <nav class="navigation navbar-flex">
        <a href="../homepage/connected.php" class="btn-home">Home</a>
        <a href="../acceptAppointment/index.php" class="btn-home btn-dashboard">Dashboard</a>
        <a href="../login_signup/logout.php" class="btn-logout">Logout</a>
      </nav>
    </header>

    <section class="profile-section">
      <?php if(!empty($success_msg)): ?>
          <div class="alert alert-success"><?= htmlspecialchars($success_msg) ?></div>
      <?php endif; ?>
      <?php if(!empty($error_msg)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error_msg) ?></div>
      <?php endif; ?>

      <div class="profile-container">
        <div class="profile-left">
          <img class="doctor-img" src="<?= $placeholderImage ?>" alt="<?= htmlspecialchars($doctor['name']) ?>" />
          <div class="rating-box">
            <span class="description">Experienced Medical Professional</span>
          </div>
          <button class="btn-main" onclick="openEditModal()">Edit Profile</button>
        </div>
        <div class="profile-right">
          <h1><?= htmlspecialchars($doctor['name']) ?></h1>
          <h3 class="specialty"><?= htmlspecialchars($doctor['specialization']) ?></h3>
          <p class="rating">★ <?= htmlspecialchars($doctor['rating']) ?> (<?= htmlspecialchars($doctor['reviews']) ?> reviews)</p>

          <div class="info-grid">
            <div class="info-item">
              <h4>Experience</h4>
              <p><?= htmlspecialchars($doctor['experience'] ?: 'Not defined') ?></p>
            </div>
            <div class="info-item">
              <h4>Consultation Fee</h4>
              <p><?= htmlspecialchars($doctor['consultation_fee'] ?: 'Not defined') ?></p>
            </div>
            <div class="info-item">
              <h4>Hospital</h4>
              <p><?= htmlspecialchars($doctor['hospital'] ?: 'Not defined') ?></p>
            </div>
            <div class="info-item">
              <h4>License No.</h4>
              <p><?= htmlspecialchars($doctor['license_number']) ?></p>
            </div>
          </div>

          <div class="about-section">
            <h2>About Doctor</h2>
            <p><?= nl2br(htmlspecialchars($doctor['about'] ?: 'No description provided yet.')) ?></p>
          </div>
          <div class="info-item contact-item doctor-contact">
            <p class="email-spacing"><strong>Email:</strong> <?= htmlspecialchars($doctor['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($doctor['phone']) ?></p>
          </div>
        </div>
      </div>
    </section>

    <div id="editModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Profile</h2>
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
        </div>
        <form method="POST" action="">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($doctor['name']) ?>" required>
          </div>
          <div class="form-group">
            <label>Specialization</label>
            <input type="text" name="specialization" value="<?= htmlspecialchars($doctor['specialization']) ?>" required>
          </div>
          <div class="form-group">
            <label>Experience</label>
            <input type="text" name="experience" value="<?= htmlspecialchars($doctor['experience']) ?>" placeholder="e.g. 15+ Years">
          </div>
          <div class="form-group">
            <label>Consultation Fee</label>
            <input type="text" name="consultation_fee" value="<?= htmlspecialchars($doctor['consultation_fee']) ?>" placeholder="e.g. $75">
          </div>
          <div class="form-group">
            <label>Hospital</label>
            <input type="text" name="hospital" value="<?= htmlspecialchars($doctor['hospital']) ?>" placeholder="e.g. HeartCare Medical Center">
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($doctor['phone']) ?>" required>
          </div>
          <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="<?= htmlspecialchars($doctor['email']) ?>" required>
          </div>
          <div class="form-group">
            <label>About</label>
            <textarea name="about"><?= htmlspecialchars($doctor['about']) ?></textarea>
          </div>
          <button type="submit" name="update_profile" class="btn-save">Save Changes</button>
        </form>
      </div>
    </div>

    <script src="doctor-profile.js"></script>
  </body>
</html>
