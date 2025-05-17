document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelectorAll(".slider .slide");

  let currentSlide = 0;

  function showNextSlide() {
    slides[currentSlide].classList.remove("active");
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].classList.add("active");
  }

  setInterval(showNextSlide, 4000); // Change image every 4 seconds
});
