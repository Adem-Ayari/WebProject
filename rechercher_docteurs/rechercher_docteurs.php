<?php
session_start();

if (empty($_SESSION['user_id'])) {
  header('Location: ../login_signup/login-register.php?force_login=1');
  exit;
}
try{
    require_once '../backend/autoloader.php';
    $repo = new Repository_database();
    
    // On récupère les données filtrées
    $name = $_GET['name'] ?? '';
    $location = $_GET['location'] ?? '';
    $specialization = $_GET['specialization'] ?? '';
    
    $doctors = $repo->FilterDoctorsByname_location_specialization($name, $location, $specialization);
    
    // Récupérer toutes les spécialités et régions pour les filtres
    $all_doctors = $repo->getAllDoctors();
    $specializations = [];
    $locations = [];
    
    foreach ($all_doctors as $doc) {
        if (!in_array($doc['specialization'], $specializations)) {
            $specializations[] = $doc['specialization'];
        }
        if (!in_array($doc['office_place'] ?? $doc['location'] ?? '', $locations) && !empty($doc['office_place'] ?? $doc['location'] ?? '')) {
            $locations[] = $doc['office_place'] ?? $doc['location'] ?? '';
        }
    }
    
    sort($specializations);
    sort($locations);
    
} catch (Exception $e) {
    $doctors = [];
    $specializations = [];
    $locations = [];
    $error_db = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>TeleMed | Online Healthcare</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <link rel="stylesheet" href="rechercher_docteurs.css" />
    <script src="rechercher_docteurs.js" defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <div class="body">
        <header class="navbar">
            <div class="logo">Health <span>Connect</span></div>
            <nav class="nav-links">
                <a href="../homepage/connected.php">Home</a>
            </nav>
            <div class="nav-actions">
                <a href="../login_signup/logout.php" class="signin text-danger fw-bold">Logout</a>
                <a href="../book/book.php" class="btn">Book Appointment</a>
            </div>
        </header>
<section class="our-doctors" id="doctors">
        <div style="text-align: center; margin-bottom: 40px">
          <h2 style="color: #0a6cff; font-size: 32px; margin-bottom: 10px">
            Meet Our Specialists
          </h2>
          <p style="color: #666; font-size: 18px">
            Connect with experienced doctors from the comfort of your home.
          </p>
        </div>

        <!-- Search Bar -->
        <div class="search-section">
          <form method="GET" class="search-form">
            <input type="text" name="name" class="search-input" placeholder="Search by name, specialty, or location..." value="<?php echo htmlspecialchars($name); ?>">
            <button type="submit" class="search-btn">Search</button>
          </form>
        </div>

        <!-- Filters and Cards Container -->
        <div class="doctors-container">
          <!-- Sidebar Filters -->
          <aside class="filters-sidebar">
            <div class="filter-card">
              <h5>Filters</h5>

              <div class="filter-group">
                <label for="spec-filter">Specialty</label>
                <select id="spec-filter" name="specialization" class="filter-select">
                  <option value="">All Specialties</option>
                  <?php foreach ($specializations as $spec): ?>
                    <option value="<?php echo htmlspecialchars($spec); ?>" <?php echo ($specialization === $spec) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($spec); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="filter-group">
                <label for="loc-filter">Location</label>
                <select id="loc-filter" name="location" class="filter-select">
                  <option value="">All Locations</option>
                  <?php foreach ($locations as $loc): ?>
                    <option value="<?php echo htmlspecialchars($loc); ?>" <?php echo ($location === $loc) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($loc); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <button onclick="applyFilters()" class="apply-btn">Apply Filters</button>
            </div>
          </aside>

          <!-- Doctors Grid -->
          <div class="doctors-grid">
        <?php if (empty($doctors)): ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">
              <p>No doctors found. Try adjusting your filters.</p>
            </div>
        <?php else: ?>
            <?php foreach ($doctors as $doc): ?>
<div class="doctor-card">
    <img src="<?php echo (!empty($doc['photo']) ? '../' . $doc['photo'] : 'https://img.freepik.com/free-photo/portrait-doctor-with-stethoscope_23-2148840478.jpg'); ?>" alt="Dr <?php echo htmlspecialchars($doc['name']); ?>" class="doctor-img">
    <h3>Dr. <?php echo htmlspecialchars($doc['name']); ?></h3>
    <p class="specialty"><?php echo htmlspecialchars($doc['specialization']); ?></p>
    <div class="rating">★ <?php echo htmlspecialchars($doc['rating']); ?> (<?php echo htmlspecialchars($doc['review_count']); ?> reviews)</div>
    <p class="bio"><?php echo htmlspecialchars($doc['bio'] ?: 'Experienced medical professional'); ?></p>
    
    <div class="info-box">
        <span>Next: <b>Today, 2PM</b></span> <span>Fee: <b>$<?php echo htmlspecialchars($doc['fee']); ?></b></span>
    </div>

    <a href="../book/book.php?id=<?php echo $doc['id']; ?>" class="btn btn-primary">Book Now</a>
    <a href="../view profile/view-profile.php?id=<?php echo $doc['id']; ?>" class="btn btn-outline">View Profile</a>
</div>
            <?php endforeach; ?>
        <?php endif; ?>
          </div>
        </div>
    </section>

    <footer>
      <p>&copy; 2026 HealthConnect. All rights reserved.</p>
    </footer>
    </div>

    <script>
      function applyFilters() {
        const specialization = document.getElementById('spec-filter').value;
        const location = document.getElementById('loc-filter').value;
        const name = document.querySelector('.search-input').value;
        
        const params = new URLSearchParams();
        if (name) params.append('name', name);
        if (location) params.append('location', location);
        if (specialization) params.append('specialization', specialization);
        
        window.location.href = '?' + params.toString();
      }
    </script>
</body>
</html>