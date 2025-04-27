const slides = document.querySelector('.slides');
const totalSlides = document.querySelectorAll('.slide').length;
let index = 0;

document.querySelector('.next').onclick = () => {
  index = (index + 1) % totalSlides;
  slides.style.transform = `translateX(-${index * 100}vw)`;
};

document.querySelector('.prev').onclick = () => {
  index = (index - 1 + totalSlides) % totalSlides;
  slides.style.transform = `translateX(-${index * 100}vw)`;
};
// Slider code (garder la partie existante du slider si nécessaire)

// Gestion du panier et du formulaire
document.addEventListener("DOMContentLoaded", function() {
  const addToCartButton = document.getElementById("add-to-cart");
  const confirmationMessage = document.getElementById("confirmation-message");
  const paymentForm = document.getElementById("payment-form");

  // Si le formulaire a été soumis, on affiche directement le message
  if (window.location.search.includes('success')) {
    confirmationMessage.style.display = "block";
    return;
  }

  addToCartButton.addEventListener("click", function() {
    paymentForm.style.display = "block";
    window.scrollTo({
      top: paymentForm.offsetTop,
      behavior: 'smooth'
    });
  });

  // Gestion du formulaire
  const form = document.getElementById("form");
  if (form) {
    form.addEventListener("submit", function(e) {
      e.preventDefault();
      
      // Ici vous pourriez ajouter une validation supplémentaire
      
      // Soumission du formulaire
      this.submit();
    });
  }
});
