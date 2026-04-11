<?php
session_start();

require_once '../backend/autoloader.php';

// Récupérer l'ID du docteur depuis GET
$doctor_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (empty($doctor_id)) {
    die('Doctor not found.');
}

try {
    $db = ConnexionDB::getInstance();
    
    // Requête pour récupérer les données du docteur
    $stmt = $db->prepare("
        SELECT 
            id, 
            name, 
            specialization, 
            experience, 
            consultation_fee AS fee, 
            hospital, 
            about, 
            rating, 
            reviews, 
            image_path,
            email,
            phone,
            office_place
        FROM Doctor 
        WHERE id = ?
        LIMIT 1
    ");
    $stmt->execute([$doctor_id]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$doctor) {
        die('Doctor not found.');
    }
    
} catch (Exception $e) {
    die('Error loading doctor profile: ' . $e->getMessage());
}

// Valeurs par défaut si vides
$doctor['image_path'] = !empty($doctor['image_path']) 
    ? '../' . $doctor['image_path'] 
    : 'https://img.freepik.com/free-photo/portrait-doctor-with-stethoscope_23-2148840478.jpg';

$doctor['about'] = $doctor['about'] ?: 'Experienced medical professional.';
$doctor['hospital'] = $doctor['hospital'] ?: 'Not specified';
$doctor['experience'] = $doctor['experience'] ?: 'Not specified';
$doctor['fee'] = $doctor['fee'] ?: '$0';
$doctor['office_place'] = $doctor['office_place'] ?: 'Not specified';

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Doctor Profile - <?php echo htmlspecialchars($doctor['name']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="view-profile.css" />
  </head>
  <body>
    <header>
      <div class="logo">Health <span>Connect</span></div>
      <nav class="navigation">
        <a href="../homepage/index.php" class="btn-home">Home</a>
        <a href="../rechercher_docteurs/rechercher_docteurs.php" class="btn-home">Find Doctors</a>
      </nav>
    </header>

    <section class="profile-section">
      <div class="profile-container">
        <div class="profile-left">
          <img class="doctor-img" src="<?php echo htmlspecialchars($doctor['image_path']); ?>" alt="<?php echo htmlspecialchars($doctor['name']); ?>" />
          <div class="rating-box">
            <span class="description">Experienced Medical Professional</span>
          </div>
          <a href="../book/book.php?id=<?php echo $doctor['id']; ?>">
            <button class="btn-main">Book Appointment</button>
          </a>
        </div>
        <div class="profile-right">
          <h1><?php echo htmlspecialchars($doctor['name']); ?></h1>
          <h3 class="specialty"><?php echo htmlspecialchars($doctor['specialization']); ?></h3>
          <p class="rating">★ <?php echo htmlspecialchars($doctor['rating']); ?> (<?php echo htmlspecialchars($doctor['reviews']); ?> reviews)</p>

          <div class="info-grid">
            <div class="info-item">
              <h4>Experience</h4>
              <p><?php echo htmlspecialchars($doctor['experience']); ?></p>
            </div>
            <div class="info-item">
              <h4>Consultation Fee</h4>
              <p><?php echo htmlspecialchars($doctor['fee']); ?></p>
            </div>
            <div class="info-item">
              <h4>Location</h4>
              <p><?php echo htmlspecialchars($doctor['office_place']); ?></p>
            </div>
            <div class="info-item">
              <h4>Hospital</h4>
              <p><?php echo htmlspecialchars($doctor['hospital']); ?></p>
            </div>
          </div>

          <div class="about-section">
            <h2>About Doctor</h2>
            <p><?php echo nl2br(htmlspecialchars($doctor['about'])); ?></p>
          </div>
          
          <div class="info-item contact-item">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($doctor['phone']); ?></p>
          </div>
        </div>
      </div>
    </section>

    <footer>
      <p>&copy; 2026 HealthConnect. All rights reserved.</p>
    </footer>
  </body>
</html>
