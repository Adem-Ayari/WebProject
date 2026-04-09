<?php
class ConnexionDB

 {
        private static $_dbname = "dbproject";                       // Set your database name here
        private static $_user = "root";                         // Set your database username here
        private static $_pwd = "";                          // Set your database password here
        private static $_host = "localhost";                         // Set your database host here
        private static $_bdd = null;
        private function __construct()

    {

    try {
self::$_bdd = new PDO("mysql:host=" . self::$_host . ";dbname=" . self::$_dbname . ";charset=utf8", self::$_user, self::$_pwd);   
 } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    }
    public static function getInstance()
    {

        if (!self::$_bdd){
            new ConnexionDB();
            return (self::$_bdd);
        }
        return (self::$_bdd);
    }

}
?>
