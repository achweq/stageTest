<?php
require_once 'create_db.php'; // use the same connection

try {
    
    $products = [
        [
            'nom' => 'Épilateur en cristal chaud',
            'description' => 'Épilateur sans douleur en verre, facile à nettoyer',
            'prix' => 3.92,
            'image' => 'img8.avif',
            'categorie' => 'epilation',
            'store_availability' => 'no'
        ],
        [
            'nom' => 'Kemei-Épilateur électrique',
            'description' => 'Épilateur pour femmes, facial, tondeuse pour bikini',
            'prix' => 20.58,
            'image' => 'img6.avif',
            'categorie' => 'epilation',
            'store_availability' => 'yes'
        ]
    ];

    foreach ($products as $product) {
        $stmt = $conn->prepare("INSERT INTO `produits` 
            (`nom`, `description`, `prix`, `image`, `categorie`,`store_availability`) 
            VALUES (:nom, :description, :prix, :image, :categorie, :store_availability)");
        $stmt->execute([
            'nom' => $product['nom'],
            'description' => $product['description'],
            'prix' => $product['prix'],
            'image' => $product['image'],
            'categorie' => $product['categorie'],
            'store_availability' => $product['store_availability'],
        ]);
    }

    echo "Tables created and products inserted.";

} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
