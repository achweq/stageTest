<?php
// Active l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration de la base
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "test";

try {
    // Étape 1: Connexion au serveur MySQL
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Étape 2: Création de la base si elle n'existe pas
    $conn->exec("CREATE DATABASE IF NOT EXISTS `$dbname` 
                CHARACTER SET utf8mb4 
                COLLATE utf8mb4_unicode_ci");
    
    // Étape 3: Sélection de la base
    $conn->exec("USE `$dbname`");
    
    // Étape 4: Création table produits
    $conn->exec("CREATE TABLE IF NOT EXISTS `produits` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `nom` VARCHAR(255) NOT NULL,
        `description` TEXT,
        `prix` DECIMAL(10,2) NOT NULL,
        `image` VARCHAR(255),
        `categorie` VARCHAR(100),
        `date_ajout` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");
    
    // Étape 5: Création table commandes
    $conn->exec("CREATE TABLE IF NOT EXISTS `commandes` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `produit_id` INT NOT NULL,
        `nom_client` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `adresse` TEXT NOT NULL,
        `numero_carte` VARCHAR(255),
        `date_commande` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`produit_id`) REFERENCES `produits`(`id`)
    ) ENGINE=InnoDB");
    
    // Étape 6: Insertion des produits
    $products = [
        [
            'nom' => 'Épilateur en cristal chaud',
            'description' => 'Épilateur sans douleur en verre, facile à nettoyer',
            'prix' => 3.92,
            'image' => 'img8.avif',
            'categorie' => 'epilation'
        ],
        [
            'nom' => 'Kemei-Épilateur électrique',
            'description' => 'Épilateur pour femmes, facial, tondeuse pour bikini',
            'prix' => 20.58,
            'image' => 'img6.avif',
            'categorie' => 'epilation'
        ]
    ];
    
    foreach ($products as $product) {
        $stmt = $conn->prepare("INSERT INTO `produits` 
                              (`nom`, `description`, `prix`, `image`, `categorie`) 
                              VALUES (:nom, :desc, :prix, :img, :cat)");
        $stmt->execute($product);
    }
    
    echo "Initialisation réussie! Tables créées et données insérées.";
    
} catch(PDOException $e) {
    die("ERREUR: " . $e->getMessage());
} finally {
    $conn = null; // Ferme la connexion
}
?>