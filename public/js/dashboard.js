let currentIndex = 0;

function moveSlide(direction) {
    const list = document.querySelector('.list');
    const totallist = list.children.length;
    currentIndex += direction;

 
    if (currentIndex < 0) {
        currentIndex = totallist - 1;
    } else if (currentIndex >= totallist) {
        currentIndex = 0;
    }

    
    const slideWidth = list.children[0].offsetWidth + 30; 
    list.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
}
