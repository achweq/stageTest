<?php
$productId = $_GET['product_id'] ?? 0;

try {
    $conn = new PDO("mysql:host=localhost;dbname=test", "root", "root");
    $stmt = $conn->prepare("SELECT nom FROM produits WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();
} catch(PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Commande confirmée</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="confirmation-message">
        <h2>Merci pour votre commande ! ✅</h2>
        <?php if($product): ?>
        <p>Votre commande de <strong><?= htmlspecialchars($product['nom']) ?></strong> a été enregistrée.</p>
        <?php endif; ?>
        <p>Un email de confirmation vous a été envoyé.</p>
    </div>
</body>
</html>