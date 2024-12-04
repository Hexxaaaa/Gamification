document.addEventListener("DOMContentLoaded", function () {
    const badgeBoxes = document.querySelectorAll(".badge-box-container");
  
    // Intersection Observer Callback
    const observerCallback = (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");  // Menambahkan kelas saat terlihat
        } else {
          entry.target.classList.remove("visible");  // Menghapus kelas saat tidak terlihat
        }
      });
    };
  
    // Intersection Observer Options
    const observerOptions = {
      root: null, // Menggunakan viewport sebagai root
      threshold: 0.1, // Memicu observer saat 10% elemen terlihat
    };
  
    // Membuat Intersection Observer
    const observer = new IntersectionObserver(observerCallback, observerOptions);
  
    // Menambahkan setiap badge-box-container untuk diamati
    badgeBoxes.forEach((box) => {
      observer.observe(box);
    });
  });
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
