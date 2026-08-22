

document.addEventListener("DOMContentLoaded", () => {
  let index = 0;
  const slides = document.querySelectorAll("#mainSlider img");

  function showSlide() {
    slides.forEach((slide, i) => {
      slide.style.display = (i === index) ? "block" : "none";
      slide.style.opacity = (i === index) ? "1" : "0";
    });

    index = (index + 1) % slides.length;
  }

  showSlide(); // Mostrar la primera imagen
  setInterval(showSlide, 3000); // Cambiar cada 3 segundos
});
