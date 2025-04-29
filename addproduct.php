<?php
require_once 'create_db.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare("INSERT INTO produits 
            (nom, description, prix, image, categorie, store_availability) 
            VALUES (:nom, :description, :prix, :image, :categorie, :store_availability)");
        
        $stmt->execute([
            'nom' => $_POST['nom'],
            'description' => $_POST['description'],
            'prix' => $_POST['prix'],
            'image' => $_POST['image'],
            'categorie' => $_POST['categorie'],
            'store_availability' => $_POST['store_availability']
        ]);

        $message = "✅ Produit ajouté avec succès!";
        $message_type = "success";

    } catch(PDOException $e) {
        $message = "❌ Erreur: " . $e->getMessage();
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit | Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="addproduct.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="logo">
                <i class="fas fa-store"></i>
                <span>Admin Panel</span>
            </div>
            <nav>
                <ul>
                    <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="active"><a href="#"><i class="fas fa-plus-circle"></i> Ajouter Produit</a></li>
                    <li><a href="#"><i class="fas fa-list"></i> Liste Produits</a></li>
                    <li><a href="#"><i class="fas fa-users"></i> Clients</a></li>
                    <li><a href="#"><i class="fas fa-chart-bar"></i> Statistiques</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="content-header">
                <h1><i class="fas fa-plus-circle"></i> Ajouter un Nouveau Produit</h1>
                <div class="user-profile">
                    <span>Admin</span>
                    <i class="fas fa-user-circle"></i>
                </div>
            </header>

            <?php if (!empty($message)): ?>
                <div class="message <?= $message_type ?>">
                    <span><?= htmlspecialchars($message) ?></span>
                    <i class="fas fa-times close-message"></i>
                </div>
            <?php endif; ?>

            <div class="form-card">
                <form method="post" class="product-form">
                    <div class="form-group">
                        <label for="nom"><i class="fas fa-tag"></i> Nom du Produit</label>
                        <input type="text" id="nom" name="nom" placeholder="Ex: iPhone 13 Pro" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description"><i class="fas fa-align-left"></i> Description</label>
                        <textarea id="description" name="description" rows="3" placeholder="Décrivez le produit..." required></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="prix"><i class="fas fa-euro-sign"></i> Prix</label>
                            <input type="number" step="0.01" id="prix" name="prix" placeholder="99.99" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="categorie"><i class="fas fa-folder"></i> Catégorie</label>
                            <select id="categorie" name="categorie" required>
                                <option value="">Sélectionner...</option>
                                <option value="Electronique">Electronique</option>
                                <option value="Vêtements">Vêtements</option>
                                <option value="Maison">Maison</option>
                                <option value="Alimentation">Alimentation</option>
                                <option value="Sport">Sport</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="image"><i class="fas fa-image"></i> Image URL</label>
                        <input type="text" id="image" name="image" placeholder="https://example.com/image.jpg" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="store_availability"><i class="fas fa-store"></i> Disponibilité</label>
                        <select id="store_availability" name="store_availability" required>
                            <option value="En stock">En stock</option>
                            <option value="Rupture de stock">Rupture de stock</option>
                            <option value="Précommande">Précommande</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Enregistrer le Produit
                        </button>
                        <button type="reset" class="btn-reset">
                            <i class="fas fa-undo"></i> Réinitialiser
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Hide message when close button is clicked
        document.querySelector('.close-message')?.addEventListener('click', function() {
            this.closest('.message').style.display = 'none';
        });
        
        // Auto-hide message after 5 seconds
        setTimeout(() => {
            const msg = document.querySelector('.message');
            if (msg) msg.style.display = 'none';
        }, 5000);
    </script>
</body>
</html>