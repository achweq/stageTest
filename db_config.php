<?php
// db_config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mayma_shop');
define('DB_USER', 'root');
define('DB_PASS', 'root');

function getDBConnection() {
    try {
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("Erreur de connexion: " . $e->getMessage());
    }
}
?>