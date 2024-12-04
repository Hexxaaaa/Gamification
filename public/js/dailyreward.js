document.addEventListener("DOMContentLoaded", function () {
    const notification = document.getElementById("notification");
    const closeBtn = document.getElementById("closeNotification");
    const badgeContainer = document.getElementById("badgeContainer");
  

    setTimeout(() => {
      notification.classList.add("visible");
    }, 500);
  
  
    closeBtn.addEventListener("click", () => {
      notification.classList.remove("visible");
    });
  
    setTimeout(() => {
      badgeContainer.classList.add("visible");
    }, 1500); 
  });
  