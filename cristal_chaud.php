<?php
require_once 'create_db.php'; // use the same connection
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produit - Épilateur en cristal chaud</title>
  <link rel="stylesheet" href="cristal_chaut.css"> <!-- Lien vers ton fichier CSS externe -->
</head>

<body>

<header>
  <div class="account">
    <a href="cart.php" class="cart">
      <span class="icon">&#128722;</span> Panier
    </a>
  </div>

  <nav class="main-nav">
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="indolore.php">indolore</a></li>
	   <li><a href="portable.php">portable</a></li>
      <li><a href="Kemei-Épilateur.php">Kemei-Épilateur</a></li>
    </ul>
  </nav>
</header>


<div class="products-list">
<?php foreach ($result as $row): ?>
  <div class="product-container">
    <div class="product-image">
      <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['nom']); ?>">
    </div>
    
    <div class="product-details">
      <h1><?php echo htmlspecialchars($row['nom']); ?></h1>
      <p class="price"><?php echo htmlspecialchars($row['prix']); ?> €</p>
      <p class="description">
        <?php echo htmlspecialchars($row['description']); ?>
      </p>
      <button class="add-to-cart">Ajouter au panier</button>
    </div>
  </div>
<?php endforeach; ?>
</div>
<!-- Formulaire Paiement caché -->
<div class="payment-form" id="payment-form" style="display: none;">
  <h2>Formulaire de Paiement</h2>
  <form id="payment-form-element" action="cristal_chaud.php" method="POST">
    <input type="hidden" name="product_id" value="1"> <!-- ID du produit -->
    
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

<!-- Script JavaScript -->
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

</body>
</html>
