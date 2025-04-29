<?php
require_once 'create_db.php';
session_start();

// Handle remove from cart action
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        $_SESSION['cart_message'] = ['type' => 'success', 'text' => 'Produit retiré du panier'];
    }
    header("Location: cart.php");
    exit;
}

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    $_SESSION['cart_message'] = ['type' => 'success', 'text' => 'Panier mis à jour'];
    header("Location: cart.php");
    exit;
}

// Get cart products
$cart_products = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
    $stmt = $conn->prepare("SELECT * FROM produits WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($_SESSION['cart']));
    $cart_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate total
    foreach ($cart_products as $product) {
        $total += $product['prix'] * $_SESSION['cart'][$product['id']];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier - Mayma Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <!-- Cart Message -->
        <?php if (isset($_SESSION['cart_message'])): ?>
            <div class="cart-message <?php echo $_SESSION['cart_message']['type']; ?>" id="cart-message">
                <i class="fas fa-<?php echo $_SESSION['cart_message']['type'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <span><?php echo $_SESSION['cart_message']['text']; ?></span>
                <span class="message-close">&times;</span>
            </div>
            <?php unset($_SESSION['cart_message']); ?>
        <?php endif; ?>
        
        <div class="cart-header">
            <h1 class="cart-title">Votre Panier</h1>
            <div class="cart-steps">
                <div class="step active">
                    <span class="step-number">1</span>
                    <span>Panier</span>
                </div>
                <div class="step">
                    <span class="step-number">2</span>
                    <span>Livraison</span>
                </div>
                <div class="step">
                    <span class="step-number">3</span>
                    <span>Paiement</span>
                </div>
            </div>
        </div>
        
        <?php if (empty($cart_products)): ?>
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h2>Votre panier est vide</h2>
                <p>Parcourez nos produits et trouvez quelque chose qui vous plaît</p>
                <a href="index.php" class="continue-shopping">Continuer vos achats</a>
            </div>
        <?php else: ?>
            <div class="cart-layout">
                <div class="cart-items">
                    <form method="post" action="cart.php">
                        <input type="hidden" name="update_cart" value="1">
                        
                        <?php foreach ($cart_products as $product): ?>
                            <div class="cart-item">
                                <div class="cart-item-image-container">
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($product['nom']); ?>"
                                         class="cart-item-image">
                                </div>
                                <div class="cart-item-details">
                                    <a href="#" class="cart-item-name"><?php echo htmlspecialchars($product['nom']); ?></a>
                                    <span class="cart-item-category"><?php echo htmlspecialchars($product['categorie']); ?></span>
                                </div>
                                <div class="cart-item-price">
                                    <?php echo number_format($product['prix'], 3, '.', ' '); ?> DT
                                </div>
                                <div class="cart-item-quantity">
                                    <input type="number" 
                                           name="quantities[<?php echo $product['id']; ?>]" 
                                           value="<?php echo $_SESSION['cart'][$product['id']]; ?>" 
                                           min="1" 
                                           class="quantity-input">
                                </div>
                                <div class="cart-item-total">
                                    <?php 
                                    $item_total = $product['prix'] * $_SESSION['cart'][$product['id']];
                                    echo number_format($item_total, 3, '.', ' '); ?> DT
                                </div>
                                <div class="cart-item-remove" onclick="window.location.href='cart.php?remove=<?php echo $product['id']; ?>'">
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <button type="submit" class="update-cart">
                            <i class="fas fa-sync-alt"></i> Mettre à jour le panier
                        </button>
                    </form>
                </div>
                
                <div class="cart-summary">
                    <h3 class="summary-title">Résumé de la commande</h3>
                    <div class="summary-row">
                        <span>Sous-total</span>
                        <span><?php echo number_format($total, 3, '.', ' '); ?> DT</span>
                    </div>
                    <div class="summary-row">
                        <span>Livraison</span>
                        <span>Calculé à l'étape suivante</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span><?php echo number_format($total, 3, '.', ' '); ?> DT</span>
                    </div>
                    <a href="checkout.php" class="checkout-btn">
                        <i class="fas fa-credit-card"></i> Passer la commande
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script>
        // Show message
        const message = document.getElementById('cart-message');
        if (message) {
            setTimeout(() => {
                message.classList.add('show');
            }, 100);
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                message.classList.remove('show');
            }, 5000);
            
            // Close button
            const closeBtn = message.querySelector('.message-close');
            closeBtn.addEventListener('click', () => {
                message.classList.remove('show');
            });
        }
    </script>
</body>
</html>