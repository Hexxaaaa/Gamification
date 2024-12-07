// Function to detect if an element is in the viewport
function isElementInViewport(el) {
  const rect = el.getBoundingClientRect();
  return rect.top >= 0 && rect.bottom <= window.innerHeight;
}

// Function to trigger the slide-up effect
function checkSlideUp() {
  const progressContainers = document.querySelectorAll('.progress-container');

  progressContainers.forEach(container => {
    if (isElementInViewport(container)) {
      container.classList.add('slide-up');
    }
  });
}

// Run the checkSlideUp function when the user scrolls
window.addEventListener('scroll', checkSlideUp);

// Run the checkSlideUp function when the page is loaded
window.addEventListener('load', checkSlideUp);