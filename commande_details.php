<?php
require_once 'create_db.php';

$commande_id = $_GET['commande_id'] ?? null;

if (!$commande_id) {
    die("ID de commande non spécifié");
}

// Get commande header
$stmt = $conn->prepare("SELECT * FROM commandes WHERE commande_id = ?");
if ($stmt === false) {
    die("Erreur de préparation de la requête commandes");
}

$stmt->execute([$commande_id]);
$commande = $stmt->fetch();

if (!$commande) {
    die("Commande non trouvée");
}

// Get all items for this commande
$stmt = $conn->prepare("
    SELECT p.nom, ci.quantite, ci.prix_unitaire 
    FROM commande_items ci
    JOIN produits p ON ci.produit_id = p.id
    WHERE ci.commande_id = ?
");

if ($stmt === false) {
    die("Erreur de préparation de la requête commande_items");
}

$stmt->execute([$commande_id]);
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la Commande #<?= $commande_id ?></title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Commande #<?= $commande_id ?></h1>
    <h3>Client: <?= htmlspecialchars($commande['nom_client']) ?></h3>
    <p>Date: <?= $commande['date_commande'] ?></p>
    
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nom']) ?></td>
                <td><?= $item['quantite'] ?></td>
                <td><?= number_format($item['prix_unitaire'], 3) ?> DT</td>
                <td><?= number_format($item['quantite'] * $item['prix_unitaire'], 3) ?> DT</td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total Général</strong></td>
                <td><strong><?= number_format($commande['montant_total'], 3) ?> DT</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>