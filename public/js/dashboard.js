function animatePoints(start, end, element) {
    let current = start;
    const step = Math.ceil((end - start) / 30);

    const animation = setInterval(() => {
        current += step;
        if (current >= end) {
            current = end;
            clearInterval(animation);
        }
        element.textContent = current.toLocaleString();
    }, 50);
}

let hasScrolled = false; // To track if the card has already appeared

window.addEventListener("scroll", function () {
    const card = document.querySelector(".card-progress");
    let currentScroll =
        window.pageYOffset || document.documentElement.scrollTop;

    if (currentScroll > 0 && !hasScrolled) {
        // Scroll Down - Show the card only once
        card.classList.add("show");
        hasScrolled = true; // Ensure card is only shown once
    }
});

// Carousel Navigation
document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector(".movie-carousel");
    const prevBtn = document.querySelector(".carousel-nav.prev");
    const nextBtn = document.querySelector(".carousel-nav.next");
    let scrollAmount = 0;
    const cardWidth = 320; // Width of each card + gap

    prevBtn.addEventListener("click", function () {
        scrollAmount = Math.max(scrollAmount - cardWidth, 0);
        carousel.style.transform = `translateX(-${scrollAmount}px)`;
    });

    nextBtn.addEventListener("click", function () {
        const maxScroll = carousel.scrollWidth - carousel.clientWidth;
        scrollAmount = Math.min(scrollAmount + cardWidth, maxScroll);
        carousel.style.transform = `translateX(-${scrollAmount}px)`;
    });
});

// Function to handle starting a task with animation
function startTaskWithAnimation(taskId) {
    // Show loading animation
    Swal.fire({
        title: "Starting Video...",
        html:
            '<div class="d-flex flex-column align-items-center">' +
            '<i class="fas fa-spinner fa-spin fa-3x mb-3 text-primary"></i>' +
            '<p class="mb-0">Preparing your video experience</p></div>',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            // Check task availability
            fetch(`/user/tasks/${taskId}/check`, {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.available) {
                        // Show success animation
                        Swal.fire({
                            icon: "success",
                            title: "Video Ready!",
                            html:
                                '<div class="d-flex flex-column align-items-center">' +
                                '<div class="mb-3">' +
                                '<i class="fas fa-check-circle text-success fa-3x"></i></div>' +
                                '<p class="mb-0">Starting video playback...</p></div>',
                            showConfirmButton: false,
                            timer: 1500,
                            willClose: () => {
                                // Create and submit form
                                const form = document.createElement("form");
                                form.method = "POST";
                                form.action = `/user/tasks/${taskId}/take`;

                                const csrfToken =
                                    document.createElement("input");
                                csrfToken.type = "hidden";
                                csrfToken.name = "_token";
                                csrfToken.value = document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content;

                                form.appendChild(csrfToken);
                                document.body.appendChild(form);
                                form.submit();
                            },
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            icon: "error",
                            title: "Video Unavailable",
                            text: data.message,
                            showConfirmButton: true,
                            confirmButtonClass:
                                "btn btn-primary rounded-pill px-4",
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong! Please try again.",
                        showConfirmButton: true,
                        confirmButtonClass: "btn btn-primary rounded-pill px-4",
                    });
                });
        },
    });
}

// Function to add task to watchlist
function startTask(taskId) {
    const token = document.querySelector('meta[name="csrf-token"]').content;

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
                // Create and submit form to add to list
                const form = document.createElement("form");
                form.method = "POST";
                form.action = `/user/tasks/${taskId}/take`;

                const csrfToken = document.createElement("input");
                csrfToken.type = "hidden";
                csrfToken.name = "_token";
                csrfToken.value = token;
                form.appendChild(csrfToken);

                // Add a hidden input to indicate this is just adding to list
                const addToList = document.createElement("input");
                addToList.type = "hidden";
                addToList.name = "add_to_list";
                addToList.value = "1";
                form.appendChild(addToList);

                document.body.appendChild(form);
                form.submit();
            } else {
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
