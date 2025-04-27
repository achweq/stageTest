<?php
// Initialisation base
require_once 'create_db.php';

// Traitement formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=test", "root", "root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation requête
        $stmt = $conn->prepare("INSERT INTO commandes 
                              (produit_id, nom_client, email, adresse, numero_carte) 
                              VALUES 
                              (1, :nom, :email, :adresse, :carte)");
        
        // Exécution
        $stmt->execute([
            ':nom' => $_POST['full-name'],
            ':email' => $_POST['email'],
            ':adresse' => $_POST['shipping-address'],
            ':carte' => $_POST['card-number']
        ]);

        $confirmation = true;
    } catch(PDOException $e) {
        $error = "Erreur: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kemei - Épilateur électrique</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- HEADER -->
<header>
  <div class="account">
    <a href="connecter.php" class="account-link">
      <span class="icon">&#128100;</span> Mon compte
    </a>
    <a href="panier.php" class="cart">
      <span class="icon">&#128722;</span> Panier
    </a>
  </div>
  <nav class="main-nav">
    <ul>
      <li><a href="dhia.php">Acceuil</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="recherche.php">Rechercher ma commande</a></li>
    </ul>
  </nav>
</header>

<!-- Conteneur du produit -->
<div class="product-container">
  <!-- Image du produit -->
  <div class="product-image">
    <img src="img6.avif" alt="Kemei - Épilateur électrique">
  </div>
  
  <!-- Détails du produit -->
  <div class="product-details">
    <h1>Kemei - Épilateur électrique</h1>
    <p class="price">$20.58</p>
    <p class="description">
      Kemei - Épilateur électrique rapide pour femmes, épilateur facial, tondeuse pour bikini, rasoir pour jambes, aisselles, bras.
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
