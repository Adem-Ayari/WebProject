DROP DATABASE IF EXISTS DBProject;
create database if not exists DBProject;
use DBProject;

-- Patient Table
CREATE TABLE Patient (
    id              INT PRIMARY KEY AUTO_INCREMENT,
    name            VARCHAR(100) NOT NULL,
    email           VARCHAR(100) UNIQUE NOT NULL,
    password        VARCHAR(255) NOT NULL DEFAULT 'password123',
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Doctor Table
CREATE TABLE Doctor (
    id              INT PRIMARY KEY AUTO_INCREMENT,
    name            VARCHAR(100) NOT NULL,
    email           VARCHAR(100) UNIQUE NOT NULL,
    password        VARCHAR(255) NOT NULL DEFAULT 'password123',
    phone           VARCHAR(15) NOT NULL,
    specialization  VARCHAR(100) NOT NULL,
    license_number  VARCHAR(50) UNIQUE NOT NULL,
    experience      VARCHAR(50) DEFAULT '0 Years',
    consultation_fee VARCHAR(50) DEFAULT '$0',
    hospital        VARCHAR(100) DEFAULT 'Not specified',
    about           TEXT,
    rating          DECIMAL(2,1) DEFAULT 0.0,
    reviews         INT DEFAULT 0,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Appointment Table
CREATE TABLE Appointment (
    appointment_id   INT PRIMARY KEY AUTO_INCREMENT,
    patient_id       INT NOT NULL,
    doctor_id        INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status          ENUM('Scheduled', 'Completed', 'Cancelled', 'No-Show') DEFAULT 'Scheduled',
    reason          VARCHAR(255),
    notes           TEXT,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    prescription_path VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY     (patient_id) REFERENCES Patient(id) ON DELETE CASCADE,
    FOREIGN KEY     (doctor_id) REFERENCES Doctor(id) ON DELETE CASCADE
);

-- Sample Data for Patient Table
INSERT INTO Patient (name, email) VALUES
('Alice Johnson', 'alice.johnson@email.com'),
('Bob Smith', 'bob.smith@email.com'),
('Carol White', 'carol.white@email.com'),
('David Brown', 'david.brown@email.com'),
('Emma Davis', 'emma.davis@email.com');

-- Sample Data for Doctor Table
INSERT INTO Doctor (name, email, phone, specialization, license_number, experience, consultation_fee, hospital, about, rating, reviews) VALUES
('Dr. James Wilson', 'james.wilson@hospital.com', '555-1001', 'Cardiology', 'LIC-2024-001', '15+ Years', '$75', 'HeartCare Medical Center', 'Expert in heart health and cardiovascular diseases.', 4.9, 120),
('Dr. Sarah Martinez', 'sarah.martinez@hospital.com', '555-1002', 'Neurology', 'LIC-2024-002', '12+ Years', '$85', 'Brain Health Clinic', 'Specialist in neurological disorders and brain health.', 4.8, 95),
('Dr. Michael Lee', 'michael.lee@hospital.com', '555-1003', 'Orthopedics', 'LIC-2024-003', '10+ Years', '$65', 'OrthoCare Hospital', 'Experienced in joint replacement and sports injuries.', 4.7, 150),
('Dr. Jennifer Taylor', 'jennifer.taylor@hospital.com', '555-1004', 'Dermatology', 'LIC-2024-004', '8+ Years', '$60', 'SkinHealth Clinic', 'Board-certified dermatologist focusing on skin treatments.', 4.9, 200),
('Dr. Christopher Anderson', 'chris.anderson@hospital.com', '555-1005', 'Pediatrics', 'LIC-2024-005', '20+ Years', '$50', 'Children''s Health Hospital', 'Compassionate pediatric care for all ages.', 5.0, 310);

-- Sample Data for Appointment Table
INSERT INTO Appointment (patient_id, doctor_id, appointment_date, appointment_time, status, reason, notes) VALUES
(1, 1, '2026-04-10', '10:00:00', 'Scheduled', 'Annual Checkup', 'Regular heart examination'),
(2, 2, '2026-04-12', '14:30:00', 'Scheduled', 'Headache Consultation', 'Patient reports recurring headaches'),
(3, 3, '2026-04-15', '09:00:00', 'Completed', 'Knee Pain', 'Knee injury assessment'),
(4, 4, '2026-04-08', '15:00:00', 'Scheduled', 'Skin Rash', 'Dermatological examination'),
(5, 5, '2026-04-20', '11:00:00', 'Scheduled', 'Immunization', 'Routine vaccination');


select * from Patient;
select * from Doctor;
select * from Appointment;