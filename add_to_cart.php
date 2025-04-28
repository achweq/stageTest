<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$id])) {
        // Update the quantity if the item is already in the cart
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        // Add the product to the cart
        $_SESSION['cart'][$id] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
           
        ];
    }

    header('Location: Shopping.php'); // Redirect to cart page after adding item
}
?>
