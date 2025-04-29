<head>
  <link rel="stylesheet" href="navbar.css">
  <!-- Other head elements -->
</head>

<nav class="navbar">
  <div class="nav-container">
    <a href="index.php" class="logo">
      <img src="images/logo.png" alt="Mayma Shop">
    </a>
    
    <div class="nav-links">
      <a href="index.php">Accueil</a>
      <a href="products.php">Produits</a>
      <a href="about.php">À propos</a>
      <a href="contact.php">Contact</a>
    </div>
    
    <div class="nav-icons">
      <a href="cart.php" class="cart-icon">
       
        <span class="icon">&#128722; <?php 
        echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
        ?></span> Panier
      </a>
    </div>
  </div>
</nav>
