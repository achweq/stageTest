<?php
// Activez le rapport d'erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérification de la méthode de requête
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'create_db.php';
    
    try {
        $conn = new PDO("mysql:host=localhost;dbname=test", "root", "root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Vérification que le produit existe
        $checkProduct = $conn->prepare("SELECT id FROM produits WHERE id = ?");
        $checkProduct->execute([$_POST['product_id']]);
        
        if ($checkProduct->rowCount() > 0) {
            // Préparation de la requête avec tous les champs nécessaires
            $stmt = $conn->prepare("INSERT INTO commandes 
                                  (produit_id, nom_client, email, adresse, numero_carte) 
                                  VALUES 
                                  (:product_id, :full_name, :email, :shipping_address, :card_number)");
            
            // Liaison des paramètres de manière explicite
            $stmt->bindParam(':product_id', $_POST['product_id'], PDO::PARAM_INT);
            $stmt->bindParam(':full_name', $_POST['full-name'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
            $stmt->bindParam(':shipping_address', $_POST['shipping-address'], PDO::PARAM_STR);
            $stmt->bindParam(':card_number', $_POST['card-number'], PDO::PARAM_STR);
            
            // Exécution
            $stmt->execute();
            
            // Redirection vers la confirmation
            header("Location: confirmation.php?product_id=".$_POST['product_id']);
            exit();
        } else {
            die("Erreur: Produit introuvable dans la base de données");
        }
    } catch(PDOException $e) {
        die("Erreur base de données: " . $e->getMessage());
    }
} else {
    header("Location: kemei.php");
    exit();
}
?>