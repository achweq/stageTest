<?php
require_once 'create_db.php';
session_start();

// Get product ID from URL
$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    die("Product ID not specified");
}

// Fetch product details
$query = "SELECT * FROM produits WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found");
}

// Handle add to cart action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1;
    
    // Initialize cart if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Add product to cart or update quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    // Set success message
    $_SESSION['success_message'] = "Produit ajouté au panier!";
    
    // Redirect to prevent form resubmission
    header("Location: productdetails.php?id=$product_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['nom']); ?> - Mayma Shop</title>
    <link rel="stylesheet" href="productdetails.css">
    <style>
        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="success-message">
            <?php 
            echo $_SESSION['success_message'];
            unset($_SESSION['success_message']); // Clear the message after displaying
            ?>
        </div>
    <?php endif; ?>
    
    <div class="product-detail-container">
        <div class="product-images">
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>" style="width: 100%; border-radius: 8px;">
        </div>
        
        <div class="product-info">
            <h1 class="product-title"><?php echo htmlspecialchars($product['nom']); ?></h1>
            
            <div class="product-specs">
                <?php echo nl2br(htmlspecialchars($product['description'] ?? 'No specifications available')); ?>
            </div>
            
            <div class="availability">
                Disponibilité : <span style="color: green;">
                <?php echo nl2br(htmlspecialchars($product['store_availability'] ?? 'No info available')); ?>
                </span>
            </div>
            
            <div class="price-section">
                <?php echo number_format($product['prix'], 3, '.', ' '); ?> DT TTC
            </div>
            
            <form method="post" action="">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="add_to_cart" value="1">
                
                <div class="quantity-selector">
                <label for="quantity">Quantité :</label>
               <input type="number" 
               id="quantity" 
               name="quantity" 
               value="1" 
               min="1" 
               step="1"
               class="quantity-input">
                </div>
                
                <button type="submit" class="add-to-cart">Ajouter Au Panier</button>
            </form>
            
            <div class="store-availability">
                <!-- You can add store availability details here if needed -->
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>