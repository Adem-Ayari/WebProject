<?php
require_once 'ConnexionDB.php';
class Repository_database {
    private $db;

    public function __construct() {
        $this->db = ConnexionBD::getInstance();
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
                    A.status AS status_cons 
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

}