<?php
require_once 'create_db.php'; // Assurez-vous que ce fichier initialise $conn

try {
    // Vérifier si la connexion à la base de données est établie
    if (!$conn) {
        throw new PDOException("La connexion à la base de données a échoué.");
    }

    $products = [
        [
            'nom' => 'Rasoir électrique portable',
            'description' => 'Rasoir électrique portable indolore pour femme, épilateur, tondeuse, appareils de soins personnels, usage domestique',
            'prix' => 4.80,
            'image' => 'img9.avif',
            'categorie' => 'epilation'
        ]
    ];

    $insertCount = 0;
    
    foreach ($products as $product) {
        $stmt = $conn->prepare("INSERT INTO `produits` 
            (`nom`, `description`, `prix`, `image`, `categorie`) 
            VALUES (:nom, :description, :prix, :image, :categorie)");
        
        $success = $stmt->execute([
            'nom' => $product['nom'],
            'description' => $product['description'],
            'prix' => $product['prix'],
            'image' => $product['image'],
            'categorie' => $product['categorie']
        ]);
        
        if ($success) {
            $insertCount++;
        } else {
            echo "Erreur lors de l'insertion du produit: " . $product['nom'] . "<br>";
        }
    }

    echo "$insertCount produits ont été insérés avec succès dans la base de données.";

} catch(PDOException $e) {
    die("Erreur de base de données: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rasoir électrique portable</title>
  <link rel="stylesheet" href="styles.css">
</head>
<style>
        /* Tu peux mettre ici ton CSS si tu ne veux pas séparer */
    header {
      background-color: #f8f9fa;
      padding: 10px 20px;
    }

    .account {
      display: flex;
      justify-content: flex-end;
      gap: 20px;
      margin-bottom: 10px;
    }

    .account-link, .cart {
      text-decoration: none;
      color: #333;
      font-weight: bold;
      font-size: 16px;
    }

    .account-link:hover, .cart:hover {
      color: #007bff;
    }

    .icon {
      margin-right: 5px;
    }

    .main-nav ul {
      list-style: none;
      display: flex;
      justify-content: center;
      gap: 30px;
      padding: 0;
      margin: 0;
    }

    .main-nav a {
      text-decoration: none;
      color: #333;
      font-size: 18px;
      font-weight: bold;
      transition: color 0.3s;
    }

    .main-nav a:hover {
      color: #007bff;
    }

    .product-container {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      gap: 30px;
      padding: 40px;
    }

    .product-image img {
      max-width: 400px;
      border-radius: 8px;
    }

    .product-details {
      max-width: 500px;
    }

    .price {
      color: #28a745;
      font-size: 24px;
      margin: 10px 0;
    }

    .payment-form, .confirmation-message {
      text-align: center;
      margin-top: 40px;
    }

    .footer {
      background-color: #343a40;
      color: white;
      padding: 20px;
      margin-top: 250px;
      display: flex;
      justify-content: space-around;
      align-items: center;
    }

    .footer a {
      color: #ffc107;
      text-decoration: none;
    }

    .newsletter input {
      padding: 8px;
      margin-right: 8px;
    }

    .newsletter button {
      padding: 8px 16px;
      background-color: #ffc107;
      border: none;
      cursor: pointer;
    }
	</style>
<body>

<!-- HEADER -->
<header>
  <div class="account">

    <a href="cart.php" class="cart">
      <span class="icon">&#128722;</span> Panier
    </a>
  </div>
  <nav class="main-nav">
    <ul>
      <li><a href="index.php">Acceuil</a></li>
      <li><a href="indolore.php">indolore</a></li>
	    <li><a href="cristal_chaud.php">cristal_chaud</a></li>
      <li><a href="Kemei-Épilateur.php">Kemei-Épilateur</a></li>
    </ul>
  </nav>
</header>

<!-- Conteneur du produit -->
<div class="product-container">
  <!-- Image du produit -->
  <div class="product-image">
    <img src="img9.avif" alt="Rasoir électrique portable">
  </div>
  
  <!-- Détails du produit -->
  <div class="product-details">
    <h1>Rasoir électrique portable</h1>
    <p class="price">$4.80</p>
    <p class="description">
      Rasoir électrique portable indolore pour femme, épilateur, tondeuse, appareils de soins personnels, usage domestique
    </p>
    <button id="add-to-cart">Ajouter au panier</button>
  </div>
</div>

<!-- Formulaire Paiement caché -->
<div class="payment-form" id="payment-form" style="display: none;">
  <h2>Formulaire de Paiement</h2>
  <form id="payment-form-element" action="cristal_chaud.php" method="POST">
    <div class="form-group">
      <label for="full-name">Nom complet</label>
      <input type="text" id="full-name" name="full-name" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="card-number">Numéro de carte</label>
      <input type="text" id="card-number" name="card-number" required>
    </div>
    <div class="form-group">
      <label for="shipping-address">Adresse de livraison</label>
      <input type="text" id="shipping-address" name="shipping-address" required>
    </div>
    <button type="submit">Confirmer le paiement</button>
  </form>
</div>

<!-- Message de confirmation -->
<div class="confirmation-message" id="confirmation-message" style="display: none;">
  <h2>Merci pour votre commande ! ✅</h2>
  <p>Votre commande a été enregistrée avec succès.</p>
</div>

<!-- SCRIPT JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const addToCartButton = document.getElementById("add-to-cart");
  const paymentForm = document.getElementById("payment-form");
  const confirmationMessage = document.getElementById("confirmation-message");

  addToCartButton.addEventListener("click", function() {
    paymentForm.style.display = "block";
    window.scrollTo({
      top: paymentForm.offsetTop,
      behavior: 'smooth'
    });
  });

  const form = document.getElementById("payment-form-element");
  if (form) {
    form.addEventListener("submit", function(e) {
      e.preventDefault();

      confirmationMessage.style.display = "block";
      paymentForm.style.display = "none";

      setTimeout(() => {
        form.reset();
      }, 3000);
    });
  }
});
</script>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-info">
    <h3>Egrowit</h3>
    <p>71-75 Shelton Street, Covent Garden, London, United Kingdom WC2H 9JQ</p>
    <p>📞 +33756756557</p>
    <p>📧 <a href="mailto:info@maymashop.com">info@maymashop.com</a></p>
  </div>
  <div class="newsletter">
    <h4>Abonnez-vous à notre newsletter</h4>
    <input type="email" placeholder="Entrer votre adresse mail">
    <button>S'inscrire</button>
  </div>
</footer>

</body>
</html>
