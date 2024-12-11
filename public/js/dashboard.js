document.addEventListener("DOMContentLoaded", function () {
    const dailyCheckInBtn = document.getElementById("dailyCheckIn");

    if (!dailyCheckInBtn) return;

    // Check initial state
    fetch("/user/check-in-status", {
        // Updated path
        headers: {
            Accept: "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            if (!data.can_check_in) {
                disableCheckInButton(dailyCheckInBtn, true);
            }
        });

    dailyCheckInBtn.addEventListener("click", function (e) {
        const button = e.currentTarget;
        button.classList.add("loading");
        button.disabled = true;

        fetch("/user/check-in", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                return response.json();
            })
            .then((data) => {
                handleSuccessfulCheckIn(button, data);
            })
            .catch((error) => {
                handleFailedCheckIn(button);
            });
    });
});

function handleSuccessfulCheckIn(button, data) {
    // Update points displays (both instances)
    const pointsDisplays = [
        document.querySelector(".fw-bold.text-primary"),
        document.querySelector(".pointuser"),
    ];

    pointsDisplays.forEach((display) => {
        if (display) {
            const oldPoints = parseInt(display.textContent.replace(/,/g, ""));
            const newPoints = oldPoints + data.points;
            animatePoints(oldPoints, newPoints, display);
        }
    });

    Swal.fire({
        icon: "success",
        title: `+${data.points} Points!`,
        text: `Day ${data.day_count} Check-in Successful!`,
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
    });

    disableCheckInButton(button, false);
}

function handleFailedCheckIn(button) {
    Swal.fire({
        icon: "error",
        title: "Already Checked In",
        text: "Come back tomorrow for more rewards!",
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
    });

    disableCheckInButton(button, true);
}

function disableCheckInButton(button, alreadyCheckedIn) {
    button.classList.remove("loading");
    button.disabled = true;
    button.classList.add("checked-in");
    button.innerHTML = `
        <img src="/gallery/coindaily.png" alt="Daily Reward" class="me-2" style="width: 24px; height: 24px;">
        <span>${alreadyCheckedIn ? "Already Checked In" : "Checked In ✓"}</span>
    `;
}

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

window.addEventListener('scroll', function() {
    const card = document.querySelector('.card-progress');
    let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    if (currentScroll > 0 && !hasScrolled) {
        // Scroll Down - Show the card only once
        card.classList.add('show');
        hasScrolled = true; // Ensure card is only shown once
    }
});



const posters = document.querySelectorAll('.poster-item');
    let currentIndex = 0;

    function updateCarousel() {
      posters.forEach((poster, index) => {
        if (index === currentIndex) {
          poster.classList.add('active');
        } else {
          poster.classList.remove('active');
        }
      });
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % posters.length;
      updateCarousel();
    }

    function prevSlide() {
      currentIndex = (currentIndex - 1 + posters.length) % posters.length;
      updateCarousel();
    }

    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });