 // Function to detect if an element is in view
 function isElementInView(element) {
    const rect = element.getBoundingClientRect();
    return rect.top <= window.innerHeight && rect.bottom >= 0;
}

// Add the 'visible' class when the element is in view
window.addEventListener('scroll', function() {
    const images = document.querySelectorAll('.image-container');
    images.forEach(function(image) {
        if (isElementInView(image)) {
            image.classList.add('visible');
        }
    });
});