main branch

<?php
class ConnexionDB
{
    private static ?PDO $_bdd = null;

    private function __construct()
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $_ENV['DB_HOST'] ?? 'localhost',
            $_ENV['DB_NAME'],
            'utf8mb4'
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
        ];

        try {
            self::$_bdd = new PDO(
                $dsn,
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                $options
            );
        } catch (PDOException $e) {
            error_log('[ConnexionDB] ' . $e->getMessage());
            throw new \Exception('Database connection failed');
        }
    }

    private function __clone() {}
    public function __wakeup(): void { throw new \Exception('Cloning/unserializing forbidden'); }

    public static function getInstance(): PDO
    {
        if (self::$_bdd === null) {
            new self();
        }
        return self::$_bdd;
    }
}