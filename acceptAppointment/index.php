<?php
session_start();

if (empty($_SESSION['doctor_id']) && empty($_SESSION['user_id'])) {
    header('Location: ../login_signup/login-register.php?force_login=1');
    exit;
}

try {
    require_once '../backend/autoloader.php';
    $repo = new Repository_database();

    $doctorId = !empty($_SESSION['doctor_id']) ? (int) $_SESSION['doctor_id'] : (int) $_SESSION['user_id'];
    $result = $repo->getAllPrescriptionsForDoctor($doctorId);
    $prescriptions = is_array($result) ? $result : [];

    $db = ConnexionDB::getInstance();
    $stmt = $db->prepare("SELECT name FROM Doctor WHERE id = ?");
    $stmt->execute([$doctorId]);
    $doctorData = $stmt->fetch(PDO::FETCH_ASSOC);
    $doctorName = $doctorData ? $doctorData['name'] : 'Doctor';
} catch (Exception $e) {
    $prescriptions = [];
    $error_db = $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Appointment Requests</title>
  <link rel="stylesheet" href="appointments.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<!-- ─── TOP NAV ──────────────────────────────── -->
<header class="navbar">
        <div class="logo">
          Health
          <span>Connect</span>
        </div>
        <nav class="nav-links">
          <a href="../homepage/connected.php">Home</a>
        </nav>

        <div class="nav-actions">
          <a href="../view profile/doctor-profile.php" class="profile-account me-3">
            <img src="https://img.freepik.com/free-photo/female-doctor-hospital-with-stethoscope_23-2148827774.jpg" alt="Profile" class="profile-avatar">
            <span class="profile-name"><?= htmlspecialchars($doctorName) ?></span>
          </a>
          <a href="../login_signup/logout.php" class="btn-logout">Logout</a>
          <a href="../doctor_calendar/doctor_calendar.php" class="btn nav-shortcut">Calendar</a>
          <a href="../prescriptions_dcotor/prescriptions_doctor.php" class="btn nav-shortcut">Prescriptions</a>
        </div>
      </header>


<!-- ════════════════════════════════════════════
     PAGE 1 — APPOINTMENT LIST
════════════════════════════════════════════ -->
<div class="page active" id="page-list">
  <div class="list-wrap">

    <div class="list-header">
      <h1>Appointment requests</h1>
      <p>Review and confirm pending patient appointments</p>
    </div>

    <!-- Stats -->
    <div class="stats">
      <div class="stat-card">
        <div class="stat-label">Total today</div>
        <div class="stat-value">8</div>
        <div class="stat-sub">Apr 17, 2026</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Pending</div>
        <div class="stat-value" style="color:#b07d1a">5</div>
        <div class="stat-sub">Awaiting review</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Confirmed</div>
        <div class="stat-value" style="color:#0f6e56">2</div>
        <div class="stat-sub">This week</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Urgent</div>
        <div class="stat-value" style="color:#c0392b">1</div>
        <div class="stat-sub">Needs attention</div>
      </div>
    </div>

    <!-- Filters -->
    <div class="filters">
      <button class="filter-btn active">All</button>
      <button class="filter-btn">Pending</button>
      <button class="filter-btn">Urgent</button>
      <button class="filter-btn">New</button>
      <button class="filter-btn">Confirmed</button>
    </div>

    <!-- ── URGENT ── -->
    <div class="section-title">Urgent</div>
    <div class="appt-list">

      <div class="appt-card" onclick="showDetail('appt1')">
        <div class="appt-avatar amber">MB</div>
        <div class="appt-main">
          <div class="appt-name">Mohamed Ben Salem</div>
          <div class="appt-meta">58 yrs · Male · +216 22 987 654</div>
          <span class="appt-reason">Chest pain, shortness of breath</span>
        </div>
        <div class="appt-right">
          <div>
            <div class="appt-time">09:00 AM</div>
            <div class="appt-date">Thu, 17 Apr</div>
          </div>
          <span class="badge badge-urgent"><span class="badge-dot"></span>Urgent</span>
        </div>
        <div class="appt-arrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
      </div>

    </div>

    <!-- ── PENDING ── -->
    <div class="section-title">Pending review</div>
    <div class="appt-list">

      <div class="appt-card" onclick="showDetail('appt2')">
        <div class="appt-avatar blue">SA</div>
        <div class="appt-main">
          <div class="appt-name">Salma Ben Amor</div>
          <div class="appt-meta">37 yrs · Female · +216 98 123 456</div>
          <span class="appt-reason">Routine cardiac follow-up</span>
        </div>
        <div class="appt-right">
          <div>
            <div class="appt-time">10:30 AM</div>
            <div class="appt-date">Thu, 17 Apr</div>
          </div>
          <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
        </div>
        <div class="appt-arrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
      </div>

      <div class="appt-card" onclick="showDetail('appt3')">
        <div class="appt-avatar green">LT</div>
        <div class="appt-main">
          <div class="appt-name">Leila Trabelsi</div>
          <div class="appt-meta">44 yrs · Female · +216 55 300 211</div>
          <span class="appt-reason">Palpitations, fatigue</span>
        </div>
        <div class="appt-right">
          <div>
            <div class="appt-time">11:15 AM</div>
            <div class="appt-date">Thu, 17 Apr</div>
          </div>
          <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
        </div>
        <div class="appt-arrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
      </div>

      <div class="appt-card" onclick="showDetail('appt4')">
        <div class="appt-avatar amber">KM</div>
        <div class="appt-main">
          <div class="appt-name">Khaled Mansouri</div>
          <div class="appt-meta">63 yrs · Male · +216 71 445 890</div>
          <span class="appt-reason">Post-surgery ECG check</span>
        </div>
        <div class="appt-right">
          <div>
            <div class="appt-time">02:00 PM</div>
            <div class="appt-date">Thu, 17 Apr</div>
          </div>
          <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
        </div>
        <div class="appt-arrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
      </div>

    </div>

    <!-- ── NEW ── -->
    <div class="section-title">New requests</div>
    <div class="appt-list">

      <div class="appt-card" onclick="showDetail('appt5')">
        <div class="appt-avatar blue">RH</div>
        <div class="appt-main">
          <div class="appt-name">Rim Hamdi</div>
          <div class="appt-meta">29 yrs · Female · +216 98 665 002</div>
          <span class="appt-reason">First consultation, referred by GP</span>
        </div>
        <div class="appt-right">
          <div>
            <div class="appt-time">03:30 PM</div>
            <div class="appt-date">Thu, 17 Apr</div>
          </div>
          <span class="badge badge-new"><span class="badge-dot"></span>New</span>
        </div>
        <div class="appt-arrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
      </div>

      <div class="appt-card" onclick="showDetail('appt6')">
        <div class="appt-avatar green">AO</div>
        <div class="appt-main">
          <div class="appt-name">Anis Oueslati</div>
          <div class="appt-meta">51 yrs · Male · +216 25 870 140</div>
          <span class="appt-reason">Hypertension management</span>
        </div>
        <div class="appt-right">
          <div>
            <div class="appt-time">04:15 PM</div>
            <div class="appt-date">Thu, 17 Apr</div>
          </div>
          <span class="badge badge-new"><span class="badge-dot"></span>New</span>
        </div>
        <div class="appt-arrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- ════════════════════════════════════════════
     PAGE 2 — APPOINTMENT DETAIL
════════════════════════════════════════════ -->
<div class="page" id="page-detail">
  <div class="detail-wrap">

    <button class="back-btn" onclick="showList()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
      Back to requests
    </button>

    <!-- Status banner -->
    <div class="status-banner">
      <div class="status-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div class="status-text">
        <h2>Appointment request received</h2>
        <p>Review the details below and confirm or reschedule.</p>
      </div>
    </div>

    <!-- Doctor -->
    <div class="d-card">
      <div class="d-card-header">
        <div class="d-card-label">Attending physician</div>
        <h3>Doctor details</h3>
      </div>
      <div class="d-card-body">
        <div class="doctor-row">
          <div class="d-avatar">KA</div>
          <div>
            <div style="font-size:16px;font-weight:600;">Dr. Karim Ayari</div>
            <div style="font-size:13px;color:var(--gray-400);margin-top:2px;">Cardiologist · Cardiology Dept.</div>
            <span class="d-avatar-badge">Available</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Appointment details — filled dynamically -->
    <div class="d-card">
      <div class="d-card-header">
        <div class="d-card-label">Scheduled visit</div>
        <h3>Appointment details</h3>
      </div>
      <div class="d-card-body">
        <div class="detail-grid">
          <div class="d-item">
            <div class="d-item-label">Date</div>
            <div class="d-item-value" id="d-date">—</div>
          </div>
          <div class="d-item">
            <div class="d-item-label">Time</div>
            <div class="d-item-value" id="d-time">—</div>
            <div class="d-item-sub">Duration: 30 min</div>
          </div>
        </div>
        <div class="d-row">
          <span class="d-row-label">Appointment type</span>
          <span class="type-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            In-person
          </span>
        </div>
        <div class="d-row">
          <span class="d-row-label">Location</span>
          <span class="d-row-value">Room 204, Block B</span>
        </div>
        <div class="d-row">
          <span class="d-row-label">Reference ID</span>
          <span class="ref-id" id="d-ref">—</span>
        </div>
      </div>
    </div>

    <!-- Patient info -->
    <div class="d-card">
      <div class="d-card-header">
        <div class="d-card-label">Patient</div>
        <h3>Patient information</h3>
      </div>
      <div class="d-card-body">
        <div class="d-row">
          <span class="d-row-label">Full name</span>
          <span class="d-row-value" id="d-name">—</span>
        </div>
        <div class="d-row">
          <span class="d-row-label">Age &amp; gender</span>
          <span class="d-row-value" id="d-age">—</span>
        </div>
        <div class="d-row">
          <span class="d-row-label">Contact</span>
          <span class="d-row-value" id="d-phone">—</span>
        </div>
        <div class="d-row">
          <span class="d-row-label">Reason for visit</span>
          <span class="d-row-value" id="d-reason">—</span>
        </div>
      </div>
    </div>

    <!-- Notes -->
    <div class="d-card">
      <div class="d-card-header">
        <div class="d-card-label">Notes</div>
        <h3>Patient's note</h3>
      </div>
      <div class="d-card-body">
        <div class="note-box" id="d-note">—</div>
      </div>
    </div>

    <!-- Actions -->
    <div class="d-actions">
      <div class="d-btn d-btn-primary">Confirm appointment</div>
      <div class="d-btn d-btn-danger">Decline</div>
    </div>
    <div class="d-actions-full">
      <div class="d-btn">Propose new time</div>
    </div>

    <div class="footer-note" id="d-footer">—</div>

  </div>
</div>

<script>
  const appointments = {
    appt1: {
      name: 'Mohamed Ben Salem',
      age: '58 yrs · Male',
      phone: '+216 22 987 654',
      reason: 'Chest pain, shortness of breath',
      note: 'Patient reports sudden chest tightness radiating to the left arm starting this morning. History of hypertension. Please prioritize and prepare ECG on arrival.',
      date: 'Thursday, 17 Apr 2026',
      time: '09:00 AM',
      ref: '#APT-2026-00479',
      submittedAt: '9 Apr 2026 at 07:02 AM'
    },
    appt2: {
      name: 'Salma Ben Amor',
      age: '37 yrs · Female',
      phone: '+216 98 123 456',
      reason: 'Routine cardiac follow-up',
      note: 'Patient reports mild shortness of breath on exertion over the past 3 weeks. Please bring all previous ECG reports and medication list. Fasting is not required.',
      date: 'Thursday, 17 Apr 2026',
      time: '10:30 AM',
      ref: '#APT-2026-00481',
      submittedAt: '9 Apr 2026 at 08:14 AM'
    },
    appt3: {
      name: 'Leila Trabelsi',
      age: '44 yrs · Female',
      phone: '+216 55 300 211',
      reason: 'Palpitations, fatigue',
      note: 'Patient has experienced irregular heartbeat episodes for 2 weeks, accompanied by general fatigue. No known cardiac history. Bring any recent blood work.',
      date: 'Thursday, 17 Apr 2026',
      time: '11:15 AM',
      ref: '#APT-2026-00483',
      submittedAt: '9 Apr 2026 at 09:45 AM'
    },
    appt4: {
      name: 'Khaled Mansouri',
      age: '63 yrs · Male',
      phone: '+216 71 445 890',
      reason: 'Post-surgery ECG check',
      note: 'Follow-up after coronary bypass surgery performed 3 weeks ago. Patient is on anticoagulants. Bring discharge summary and full medication list.',
      date: 'Thursday, 17 Apr 2026',
      time: '02:00 PM',
      ref: '#APT-2026-00485',
      submittedAt: '9 Apr 2026 at 10:30 AM'
    },
    appt5: {
      name: 'Rim Hamdi',
      age: '29 yrs · Female',
      phone: '+216 98 665 002',
      reason: 'First consultation, referred by GP',
      note: 'GP referral due to persistent tachycardia detected during routine checkup. No prior cardiac history. Patient is not on any medication.',
      date: 'Thursday, 17 Apr 2026',
      time: '03:30 PM',
      ref: '#APT-2026-00488',
      submittedAt: '9 Apr 2026 at 11:00 AM'
    },
    appt6: {
      name: 'Anis Oueslati',
      age: '51 yrs · Male',
      phone: '+216 25 870 140',
      reason: 'Hypertension management',
      note: 'Patient on current antihypertensive medication for 6 months. Requesting review and possible dosage adjustment. Bring home blood pressure log if available.',
      date: 'Thursday, 17 Apr 2026',
      time: '04:15 PM',
      ref: '#APT-2026-00490',
      submittedAt: '9 Apr 2026 at 11:48 AM'
    }
  };

  function showDetail(id) {
    const a = appointments[id];
    if (!a) return;
    document.getElementById('d-name').textContent   = a.name;
    document.getElementById('d-age').textContent    = a.age;
    document.getElementById('d-phone').textContent  = a.phone;
    document.getElementById('d-reason').textContent = a.reason;
    document.getElementById('d-note').textContent   = a.note;
    document.getElementById('d-date').textContent   = a.date;
    document.getElementById('d-time').textContent   = a.time;
    document.getElementById('d-ref').textContent    = a.ref;
    document.getElementById('d-footer').innerHTML   = 'Request submitted on ' + a.submittedAt + '<br>For urgent changes, contact reception at +216 71 000 000';

    document.getElementById('page-list').classList.remove('active');
    document.getElementById('page-detail').classList.add('active');
    window.scrollTo({ top: 0 });
  }

  function showList() {
    document.getElementById('page-detail').classList.remove('active');
    document.getElementById('page-list').classList.add('active');
    window.scrollTo({ top: 0 });
  }
</script>

</body>
</html>