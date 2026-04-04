<?php
session_start();

if (empty($_SESSION['user_id'])) {
  header('Location: ../login_signup/login-register.php?force_login=1');
  exit;
}
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HealthConnect - Book Appointment</title>
    <link rel="stylesheet" href="book.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  </head>
  <body>
    <header>
      <h2 class="logo">
        Health
        <span>Connect</span>
      </h2>
      <nav class="navigation">
        <a href="../homepage/connected.php" class="btn-home">Home</a>
      </nav>
    </header>

    <div class="wrapper">
      <div class="form-box-book">
        <h2>Book Your Appointment</h2>
        <p class="subtitle">Schedule a consultation with one of our trusted doctors</p>
        <form action="#" method="POST" class="appointment-form">
          <div class="form-grid">
            <div class="input-box">
              <input type="text" required />
              <label>Full Name</label>
              <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
            </div>

            <div class="input-box">
              <input type="email" required />
              <label>Email Address</label>
              <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
            </div>

            <div class="input-box">
              <input type="tel" required />
              <label>Phone Number</label>
              <span class="icon"><ion-icon name="call-outline"></ion-icon></span>
            </div>

            <div class="input-box">
              <select id="doctorSelect" required>
                <option value="" disabled selected></option>
              </select>
              <label>Choose Doctor</label>
            </div>

            <div class="input-box">
              <input type="date" required />
              <label>Preferred Date</label>
              <span class="icon"><ion-icon name="calendar-outline"></ion-icon></span>
            </div>

            <div class="input-box">
              <input type="time" required />
              <label>Preferred Time</label>
              <span class="icon"><ion-icon name="time-outline"></ion-icon></span>
            </div>

            <div class="input-box full-width">
              <textarea required></textarea>
              <label>Additional Notes</label>
              <span class="icon"><ion-icon name="document-text-outline"></ion-icon></span>
            </div>
          </div>

          <button type="submit" class="btn-main full-width">Book Appointment</button>
          <script type="module">
            import { doctors } from "./doctor-data.js";

            const select = document.getElementById("doctorSelect");

            doctors.forEach((doctor) => {
              const option = document.createElement("option");
              option.value = doctor.id; // use ID
              option.textContent = doctor.name; // use name
              select.appendChild(option);
            });
          </script>
        </form>
      </div>
    </div>
  </body>
</html>
