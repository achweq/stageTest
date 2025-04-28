<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Hanuel • Payment Options</title>
    <style>
        /* Basic Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        
        main {
            padding: 20px;
            max-width: 600px;
            margin: 30px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .payment-form {
            display: flex;
            flex-direction: column;
        }

        .payment-option {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .payment-option input[type="radio"] {
            margin-right: 10px;
        }

        .payment-label {
            display: flex;
            align-items: center;
            font-size: 16px;
            color: #333;
        }

        .payment-label img {
            margin-right: 10px;
            width: 40px;
        }

        .card-details, .paypal-details {
            display: none;
            margin-top: 15px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 8px;
        }

        .card-details label, .paypal-details label {
            font-size: 14px;
            color: #555;
        }

        .card-details input, .paypal-details input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .submit-button {
            padding: 15px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-button:hover {
            background-color: #45a049;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>

<main>
    <h2>Choose Your Payment Method</h2>
    <form action="payment_process.php" method="POST" class="payment-form">
        
        <!-- Credit/Debit Card Payment -->
        <div class="payment-option">
            <input type="radio" id="credit-card" name="payment_method" value="credit_card" checked>
            <label for="credit-card" class="payment-label">
                <img src="images/credit_card.png" alt="Credit Card Icon">
                Pay with Credit/Debit Card
            </label>
            <div class="card-details" id="card-details">
                <label for="card-number">Card Number</label>
                <input type="text" id="card-number" name="card_number" placeholder="1234 5678 9876 5432" required>
                
                <label for="expiry-date">Expiry Date</label>
                <input type="text" id="expiry-date" name="expiry_date" placeholder="MM/YY" required>
                
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="123" required>
            </div>
        </div>
        
        <!-- PayPal Payment -->
        <div class="payment-option">
            <input type="radio" id="paypal" name="payment_method" value="paypal">
            <label for="paypal" class="payment-label">
                <img src="images/paypal.png" alt="PayPal Icon">
                Pay with PayPal
            </label>
            <div class="paypal-details" id="paypal-details">
                <label for="paypal-email">PayPal Account Email</label>
                <input type="email" id="paypal-email" name="paypal_email" placeholder="youremail@example.com" required>

                <label for="paypal-card-number">PayPal Linked Card Number</label>
                <input type="text" id="paypal-card-number" name="paypal_card_number" placeholder="1234 5678 9876 5432">
            </div>
        </div>
        
        <!-- Buy Now, Pay Later (BNPL) -->
        <div class="payment-option">
            <input type="radio" id="bnpl" name="payment_method" value="bnpl">
            <label for="bnpl" class="payment-label">
                <img src="images/bnpl.png" alt="Buy Now, Pay Later Icon">
                Pay with Afterpay / Klarna
            </label>
        </div>
        
        <!-- Submit Payment -->
        <input type="submit" value="Proceed to Payment" class="submit-button">
    </form>
</main>

<footer>
    <p>&copy; 2024 Hanuel. All Rights Reserved.</p>
</footer>

<script>
    // Show/Hide Payment Details based on selected payment method
    const creditCardOption = document.getElementById('credit-card');
    const paypalOption = document.getElementById('paypal');
    const bnplOption = document.getElementById('bnpl');
    const cardDetails = document.getElementById('card-details');
    const paypalDetails = document.getElementById('paypal-details');

    // Event listener for radio buttons
    creditCardOption.addEventListener('change', togglePaymentDetails);
    paypalOption.addEventListener('change', togglePaymentDetails);
    bnplOption.addEventListener('change', togglePaymentDetails);

    // Function to toggle payment details display
    function togglePaymentDetails() {
        if (creditCardOption.checked) {
            cardDetails.style.display = 'block';
            paypalDetails.style.display = 'none';
        } else if (paypalOption.checked) {
            paypalDetails.style.display = 'block';
            cardDetails.style.display = 'none';
        } else {
            paypalDetails.style.display = 'none';
            cardDetails.style.display = 'none';
        }
    }

    // Initialize visibility based on default selection
    togglePaymentDetails();
</script>

</body>
</html>
