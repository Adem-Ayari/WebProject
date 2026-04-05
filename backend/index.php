<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    include 'ConnexionDB.php';
    
    // Get database connection
    $db = ConnexionBD::getInstance();
    
    if (!$db) {
        throw new Exception("Failed to get database connection");
    }
    
    // Define the user ID you want to fetch
    $userId = 1;
    
    // Prepare and execute query
    $query = $db->prepare("SELECT * FROM Patient WHERE id = ?");
    
    if (!$query) {
        throw new Exception("Prepare failed: " . implode(" ", $db->errorInfo()));
    }
    
    $executed = $query->execute([$userId]);
    
    if (!$executed) {
        throw new Exception("Execute failed: " . implode(" ", $query->errorInfo()));
    }
    
    $result = $query->fetch();
    
    // Display the result
    if ($result) {
        echo "Patient found: " . $result['name'];
        echo "<pre>";
        //print_r($result);
        echo "</pre>";
    } else {
        echo "Patient not found (no patient with id = " . $userId . ")";
    }
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    echo "<br>Error Code: " . $e->getCode();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>