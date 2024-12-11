// Function to detect if an element is in view
function isElementInView(element) {
    const rect = element.getBoundingClientRect();
    return rect.top <= window.innerHeight && rect.bottom >= 0;
}

// Add the 'visible' class when the element is in view
window.addEventListener("scroll", function () {
    const images = document.querySelectorAll(".image-container");
    images.forEach(function (image) {
        if (isElementInView(image)) {
            image.classList.add("visible");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.querySelector("form.d-flex");
    const searchInput = searchForm.querySelector('input[type="text"]');

    searchForm.addEventListener("submit", function (e) {
        e.preventDefault();

        fetch(`/search?search=${searchInput.value}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Refresh the page with search results
                    window.location.href = `/?search=${searchInput.value}`;
                }
            })
            .catch((error) => console.error("Error:", error));
    });
});

function startTask(taskId) {
    // Get CSRF token from meta tag
    const token = document.querySelector('meta[name="csrf-token"]').content;

    // Make AJAX request to check task availability first
    fetch(`/user/tasks/${taskId}/check`, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": token,
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.available) {
                // If task is available, create and submit form
                const form = document.createElement("form");
                form.method = "POST";
                form.action = `/user/tasks/${taskId}/take`;

                const csrfToken = document.createElement("input");
                csrfToken.type = "hidden";
                csrfToken.name = "_token";
                csrfToken.value = token;
                form.appendChild(csrfToken);

                document.body.appendChild(form);
                form.submit();
            } else {
                // Show error message using SweetAlert2
                Swal.fire({
                    icon: "error",
                    title: "Task Unavailable",
                    text: data.message,
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                });
            }
        });
}

// Add hover effect to task cards
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".task-card").forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-5px)";
            this.style.transition = "transform 0.3s ease";
            this.style.boxShadow = "0 4px 15px rgba(0,0,0,0.1)";
        });

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)";
            this.style.boxShadow = "none";
        });
    });
});

function startTaskWithAnimation(taskId) {
    // First show loading animation
    Swal.fire({
        title: 'Starting Task...',
        html: '<div class="d-flex flex-column align-items-center">' +
              '<i class="fas fa-spinner fa-spin fa-3x mb-3 text-primary"></i>' +
              '<p class="mb-0">Preparing your task experience</p></div>',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            // Check task availability
            fetch(`/user/tasks/${taskId}/check`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.available) {
                    // Show success animation
                    Swal.fire({
                        icon: 'success',
                        title: 'Task Ready!',
                        html: '<div class="d-flex flex-column align-items-center">' +
                              '<div class="mb-3">' +
                              '<i class="fas fa-check-circle text-success fa-3x"></i></div>' +
                              '<p class="mb-0">Your task is being prepared...</p></div>',
                        showConfirmButton: false,
                        timer: 1500,
                        willClose: () => {
                            // Create and submit form
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/user/tasks/${taskId}/take`;
                            
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
                            
                            form.appendChild(csrfToken);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Task Unavailable',
                        text: data.message,
                        showConfirmButton: true,
                        confirmButtonClass: 'btn btn-primary rounded-pill px-4',
                        confirmButtonText: 'Got it'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again.',
                    showConfirmButton: true,
                    confirmButtonClass: 'btn btn-primary rounded-pill px-4'
                });
            });
        }
    });
}