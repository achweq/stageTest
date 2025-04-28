<?php
require_once 'create_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare("INSERT INTO produits 
            (nom, description, prix, image, categorie,store_availability) 
            VALUES (:nom, :description, :prix, :image, :categorie, :store_availability)");
        
        $stmt->execute([
            'nom' => $_POST['nom'],
            'description' => $_POST['description'],
            'prix' => $_POST['prix'],
            'image' => $_POST['image'],
            'categorie' => $_POST['categorie'],
            'store_availability' => $_POST['store_availability']

        ]);

        echo "Product added successfully.";

    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        form { width: 300px; }
        input, textarea { width: 100%; margin-bottom: 10px; }
    </style>
</head>
<body>

<h2>Add New Product</h2>

<form method="post">
    <input type="text" name="nom" placeholder="Product Name" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="number" step="0.01" name="prix" placeholder="Price" required>
    <input type="text" name="image" placeholder="Image Path (e.g., img.jpg)" required>
    <input type="text" name="categorie" placeholder="Category" required>
    <input type="text" name="store_availability" placeholder="store_availability" required>
    <button type="submit">Add Product</button>
</form>

</body>
</html>
