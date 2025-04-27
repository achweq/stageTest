<div class="payment-form" id="payment-form" style="display: none;">
    <h2>Formulaire de Paiement</h2>
    <form method="POST" action="process_payment.php">
        <input type="hidden" name="product_id" value="<?= $productId ?>">
        
        <div class="form-group">
            <label>Nom complet</label>
            <input type="text" name="full-name" required>
        </div>
        
        <!-- Autres champs du formulaire -->
        
        <button type="submit">Confirmer</button>
    </form>
</div>