// Get the navbar element
const navbar = document.querySelector(".navbar");

// Function to toggle the burger menu
function toggleBurgerMenu() {
  navbar.classList.toggle("active");
}

// Function to handle scroll event
function handleScroll() {
  if (window.pageYOffset > 0) {
    navbar.classList.add("sticky");
  } else {
    navbar.classList.remove("sticky");
  }
}

// Add event listener for burger menu toggle
document
  .querySelector(".navbar-nav")
  .addEventListener("click", toggleBurgerMenu);

// Add event listener for scroll
window.addEventListener("scroll", handleScroll);
