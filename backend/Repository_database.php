<?php
require_once 'ConnexionDB.php';
class Repository_database {
    private $db;

    public function __construct() {
        $this->db = ConnexionDB::getInstance();
    }
    // creer le repository pour la base de donnees (une classe qui va faire toutes les requetes a la base de donnees)
    // Example method to get all appointments for a specific patient
    public function getAllAppointmentsForPatient($patientId) {
        try {
            // Utilisation d'un JOIN pour récupérer le nom et la spécialité du docteur
            $stmt = $this->db->prepare(" 
                SELECT 
                    A.appointment_date AS date_cons, 
                    D.specialization AS type_cons, 
                    D.name AS doctor_name, 
                    A.status AS status_cons,
                    A.prescription_path AS prescription_path
                FROM Appointment A
                INNER JOIN Doctor D ON A.doctor_id = D.id
                WHERE A.patient_id = ? 
                ORDER BY A.appointment_date DESC
            ");
            $stmt->execute([$patientId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getAllPrescriptionsForDoctor($doctorId) {
        try {
            $stmt = $this->db->prepare(" 
                SELECT 
                    A.appointment_id AS appointment_id,
                    A.appointment_date AS date_cons,
                    P.name AS patient_name,
                    A.reason AS medical_resume,
                    A.status AS status_cons,
                    A.prescription_path AS prescription_path
                FROM Appointment A
                INNER JOIN Patient P ON A.patient_id = P.id
                WHERE A.doctor_id = ?
                ORDER BY A.appointment_date DESC
            ");
            $stmt->execute([$doctorId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
    public function getAllDoctors() {
        try {
            $stmt = $this->db->prepare("SELECT id, name, specialization, office_place FROM Doctor order by name asc");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
    public function bookAppointment($patientId, $doctorId, $appointmentDate, $appointmentTime, $reason, $notes) {
        try {
            if(strtotime($appointmentDate) < strtotime(date('Y-m-d'))) {
                return false; // Cannot book an appointment in the past
            }
            else if(strtotime($appointmentDate) == strtotime(date('Y-m-d')) && strtotime($appointmentTime) < strtotime(date('H:i'))) {
                return false; // Cannot book an appointment for earlier today
            }
            else {
            $stmt = $this->db->prepare("INSERT INTO Appointment (patient_id, doctor_id, appointment_date,appointment_time,status, reason, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$patientId, $doctorId, $appointmentDate, $appointmentTime, 'pending', $reason, $notes]);
            return true;}
        } catch (Exception $e) {
            return false;
        }
    }
    public function FilterDoctorsByname_location_specialization($name, $location, $specialization) {
    try {
        // On récupère toutes les colonnes nécessaires pour la carte
        $query = "SELECT id, name, specialization, office_place, image_path AS photo, rating, reviews AS review_count, consultation_fee AS fee, about AS bio, experience
            FROM Doctor 
            WHERE 1=1";
        $params = [];

        if (!empty($name)) {
            $query .= " AND name LIKE ?";
            $params[] = '%' . $name . '%';
        }
        if (!empty($location)) {
            $query .= " AND office_place LIKE ?";
            $params[] = '%' . $location . '%';
        }
        if (!empty($specialization)) {
            $query .= " AND specialization LIKE ?";
            $params[] = '%' . $specialization . '%';
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Il est préférable de logger l'erreur pour le debug
        error_log($e->getMessage());
        return [];
    }
}

}