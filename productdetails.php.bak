<?php
require_once 'create_db.php';

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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['nom']); ?> - Mayma Shop</title>
    <link rel="stylesheet" href="productdetails.css">

</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="product-detail-container">
        <div class="product-images">
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>" style="width: 100%; border-radius: 8px;">
        </div>
        
        <div class="product-info">
            <h1 class="product-title"><?php echo htmlspecialchars($product['nom']); ?></h1>
            
            <div class="product-specs">
                <?php 
                // Assuming you have a 'specs' column in your database with the specifications
                // If not, you'll need to adjust this to match your database structure
                echo nl2br(htmlspecialchars($product['description'] ?? 'No specifications available'));
                ?>
            </div>
            
            <div class="availability">
                Disponibilité : <span style="color: green;"> <?php 
                echo nl2br(htmlspecialchars($product['store_availability'] ?? 'No info   available'));
                ?></span>
            </div>
            
            <div class="price-section">
                <?php echo number_format($product['prix'], 3, '.', ' '); ?> DT TTC
            </div>
            
            <div class="quantity-selector">
                <label for="quantity">Quantité :</label>
                <select id="quantity" name="quantity">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            
            <button class="add-to-cart">Ajouter Au Panier</button>
            
            <div class="store-availability">
                <h3>Magasin</h3>
                <ul>
                    <li>Boutique Tunis - <span class="available">Disponible</span></li>
                    <li>Sousse - <span class="not-available">Non disponible</span></li>
                    <li>Sfax - <span class="not-available">Non disponible</span></li>
                    <li>Tunis Drive-In - <span class="available">Disponible</span></li>
                </ul>
            </div>
            
            <div class="payment-options">
                <h3>Payez en plusieurs fois par traites</h3>
                <table>
                    <tr>
                        <th>12 mois</th>
                        <th>9 mois</th>
                        <th>6 mois</th>
                        <th>3 mois</th>
                    </tr>
                    <tr>
                        <td>46.034 DT</td>
                        <td>58.087 DT</td>
                        <td>84.957 DT</td>
                        <td>153 DT</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>