<?php
require_once 'create_db.php'; // use the same connection

try {
    
    $products = [
        [
            'nom' => 'Épilateur en cristal chaud',
            'description' => 'Épilateur sans douleur en verre, facile à nettoyer',
            'prix' => 3.92,
            'image' => 'images/img8.avif',
            'categorie' => 'epilation',
            'store_availability' => 'yes'
        ],
        [
            'nom' => 'Kemei-Épilateur électrique',
            'description' => 'Épilateur pour femmes, facial, tondeuse pour bikini',
            'prix' => 20.58,
            'image' => 'images/img6.avif',
            'categorie' => 'epilation',
            'store_availability' => 'yes'
        ],
		[
            'nom' => 'Épilateur laser électrique indolore',
            'description' => 'Épilateur laser électrique indolore, photoépilateur en continu IPL, machine d’épilation, 999999 flashs, offre spéciale, nouveau',
            'prix' => 34.26,
            'image' => 'images/img5.avif',
            'categorie' => 'epilation',
            'store_availability' => 'yes'
        ],
		[
            'nom' => 'Rasoir électrique portable',
            'description' => 'Rasoir électrique portable indolore pour femme, épilateur, tondeuse, appareils de soins personnels, usage domestique',
            'prix' => 4.80,
            'image' => 'images/img2.avif',
            'categorie' => 'epilation',
            'store_availability' => 'yes'
        ],
		[
            'nom' => 'Nourishing Nail & Cuticle Serum',
            'description' => 'Rasoir électrique portable indolore pour femme, épilateur, tondeuse, appareils de soins personnels, usage domestique',
            'prix' => 4.80,
            'image' => 'images/img2.avif',
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
