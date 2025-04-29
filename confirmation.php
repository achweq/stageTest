<?php
require_once 'create_db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation - Mayma Shop</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .confirmation-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            text-align: center;
            background: #f9f9f9;
            border-radius: 8px;
        }
        
        .confirmation-icon {
            font-size: 60px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="confirmation-container">
        <div class="confirmation-icon">✓</div>
        <h1>Merci pour votre commande!</h1>
        <p>Votre commande a été passée avec succès.</p>
        <p>Un email de confirmation vous a été envoyé.</p>
        <a href="index.php" class="voir-plus">Retour à la boutique</a>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>