<?php
require_once 'create_db.php'; // use the same connection

$query = "SELECT * FROM produits";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mayma Shop - Accueil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>


<!-- SLIDER -->
<h1><b><i>Maymashop</i></b></h1>

<section class="slider">
  <div class="slides">
    <div class="slide">
      <img src="sl1.png" alt="Produit 1">
    </div>
    <div class="slide">
      <img src="sl2.png" alt="Produit 2">
    </div>
  </div>

  <!-- Boutons pour naviguer -->
  <button class="prev">&#10094;</button>
  <button class="next">&#10095;</button>
</section>

<!-- PRODUITS -->
<section class="products">
<div class="products-row">
    <?php foreach ($result as $row): ?>
      <div class="product-item">
        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['nom']); ?>">
        <h3><?php echo htmlspecialchars($row['nom']); ?></h3>
        <p><?php echo htmlspecialchars($row['prix']); ?> €</p>
        <a href="productdetails.php?id=<?php echo urlencode($row['id']); ?>" class="voir-plus">Voir plus</a>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="products-description">
    <p>
      Découvrez l’épilation électrique, la solution rapide et efficace pour une peau lisse et soyeuse !<br>
      Grâce à sa technologie innovante, cet appareil élimine les poils durablement tout en minimisant la douleur.<br>
      Adapté à tous les types de peau, il vous offre un confort personnalisé.<br>
      Transformez votre routine beauté et savourez la sensation d’une peau impeccable !
    </p>
  </div>
</section>

<!-- FORMULAIRE DE CONTACT -->
<section class="contact-section">
  <h2>Contactez-nous</h2>
  <form class="contact-form">
    <input type="text" placeholder="Votre nom" required>
    <input type="text" placeholder="Votre prénom" required>
    <input type="email" placeholder="Votre e-mail" required>
    <button type="submit">Envoyer</button>
  </form>
</section>

<!-- FOOTER -->
<?php include 'footer.php'; ?>
<script src="script.js"></script>
</body>
</html>
