<?php
require_once 'create_db.php';
session_start();

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: panier.php");
    exit;
}


// Calculate total FIRST
$total = 0;
$cart_items = [];
if (!empty($_SESSION['cart'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
    $stmt = $conn->prepare("SELECT id, nom, prix FROM produits WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($_SESSION['cart']));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($products as $product) {
        $quantity = $_SESSION['cart'][$product['id']];
        $cart_items[] = [
            'id' => $product['id'],
            'nom' => $product['nom'],
            'prix' => $product['prix'],
            'quantite' => $quantity
        ];
        $total += $product['prix'] * $quantity;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn->beginTransaction();
        
        // 1. Create the commande
        $stmt = $conn->prepare("INSERT INTO commandes 
            (nom_client, email, adresse, numero_carte, montant_total) 
            VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['nom'],
            $_POST['email'],
            $_POST['adresse'],
            $_POST['numero_carte'],
            $total // Now this is calculated
        ]);
        
        $commande_id = $conn->lastInsertId();
        
        // 2. Add all cart items to commande_items
        $stmt = $conn->prepare("INSERT INTO commande_items 
            (commande_id, produit_id, quantite, prix_unitaire) 
            VALUES (?, ?, ?, ?)");
            
        foreach ($_SESSION['cart'] as $produit_id => $quantite) {
            // Get current product price
            $product_stmt = $conn->prepare("SELECT prix FROM produits WHERE id = ?");
            $product_stmt->execute([$produit_id]);
            $produit = $product_stmt->fetch();
            
            $stmt->execute([
                $commande_id,
                $produit_id,
                $quantite,
                $produit['prix']
            ]);
        }
        
        $conn->commit();
        unset($_SESSION['cart']);
        header("Location: confirmation.php?commande_id=$commande_id");
        exit;
        
    } catch(PDOException $e) {
        $conn->rollBack();
        die("Erreur lors de la commande: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement - Mayma Shop</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .checkout-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            gap: 30px;
        }
        
        .checkout-form {
            flex: 2;
        }
        
        .order-summary {
            flex: 1;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .submit-btn {
            background: #e60023;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="checkout-container">
        <form method="post" class="checkout-form">
            <h2>Informations de livraison</h2>
            
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="nom">Nom complet</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="adresse">Adresse</label>
                <textarea id="adresse" name="adresse" rows="3" required></textarea>
            </div>
            
            <h2>Informations de paiement</h2>
            
            <div class="form-group">
                <label for="numero_carte">Numéro de carte</label>
                <input type="text" id="numero_carte" name="numero_carte" required>
            </div>
            
            <button type="submit" class="submit-btn">Confirmer la commande</button>
        </form>
        
        <div class="order-summary">
            <h3>Votre commande</h3>
            <p>Total: <?php echo number_format($total, 3, '.', ' '); ?> DT</p>
            
            <h4>Produits:</h4>
            <ul>
                <?php foreach ($cart_items as $item): ?>
                    <li>
                        <?php echo htmlspecialchars($item['nom']); ?> 
                        (<?php echo $item['quantite']; ?> × <?php echo number_format($item['prix'], 3); ?> DT)
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>