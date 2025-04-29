<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maymashop";

try {
    // First connect WITHOUT database
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if database exists
    $stmt = $conn->query("SHOW DATABASES LIKE '$dbname'");
    $dbExists = $stmt->fetch();

    // If not exists, create it
    if (!$dbExists) {
        $conn->exec("CREATE DATABASE `$dbname` 
                     CHARACTER SET utf8mb4 
                     COLLATE utf8mb4_unicode_ci");
    }

    // Now connect to the database
    $conn->exec("USE `$dbname`");


    // Create produits table if not exists
    $conn->exec("CREATE TABLE IF NOT EXISTS `produits` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `nom` VARCHAR(255) NOT NULL,
        `description` TEXT,
        `prix` DECIMAL(10,2) NOT NULL,
        `image` VARCHAR(255),
        `categorie` VARCHAR(100),
        `store_availability` VARCHAR(255),
        `date_ajout` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");

// Create new structure
$conn->exec("CREATE TABLE IF NOT EXISTS `commandes` (
    `commande_id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom_client` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `adresse` TEXT NOT NULL,
    `numero_carte` VARCHAR(255),
    `montant_total` DECIMAL(10,2) NOT NULL,
    `date_commande` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB");

$conn->exec("CREATE TABLE IF NOT EXISTS `commande_items` (
    `item_id` INT AUTO_INCREMENT PRIMARY KEY,
    `commande_id` INT NOT NULL,
    `produit_id` INT NOT NULL,
    `quantite` INT NOT NULL,
    `prix_unitaire` DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (`commande_id`) REFERENCES `commandes`(`commande_id`),
    FOREIGN KEY (`produit_id`) REFERENCES `produits`(`id`)
) ENGINE=InnoDB");;
} catch(PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>
