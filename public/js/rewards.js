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

// Initialize when document is ready
document.addEventListener("DOMContentLoaded", function() {
    const checkInButton = document.getElementById('checkInButton');
    const progressContainer = document.getElementById('progressContainer');
    
    if (!checkInButton) return;

    // Initial check of check-in status
    updateCheckInStatus();

    checkInButton.addEventListener('click', function() {
        // Disable button and show loading state
        checkInButton.disabled = true;
        checkInButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking in...';

        fetch('/user/checkin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                handleSuccessfulCheckIn(data);
                updateProgressSteps(data.day_count);
            } else {
                handleFailedCheckIn();
            }
        })
        .catch(() => handleFailedCheckIn());
    });

    function updateCheckInStatus() {
        fetch('/user/checkin-status')
            .then(response => response.json())
            .then(data => {
                updateProgressSteps(data.current_streak);
                if (!data.can_check_in) {
                    disableCheckInButton();
                }
                updateNextReward(data.next_reward);
                updateStreak(data.current_streak);
            });
    }

    function handleSuccessfulCheckIn(data) {
        // Update UI to show success
        Swal.fire({
            icon: 'success',
            title: `+${data.points} Points!`,
            text: `Day ${data.day_count} Check-in Complete!`,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        // Update points display
        updateTotalPoints(data.points);
        
        // Disable check-in button for today
        disableCheckInButton();
    }

    function updateProgressSteps(currentDay) {
        const steps = document.querySelectorAll('.progress-step');
        const lines = document.querySelectorAll('.line');
    
        steps.forEach((step, index) => {
            const dayNumber = index + 1;
            if (dayNumber <= currentDay) {
                step.classList.add('completed');
                if (dayNumber === currentDay) {
                    step.classList.add('current');
                } else {
                    step.classList.remove('current');
                }
                step.querySelector('.step-label').textContent = 'Completed';
            } else {
                step.classList.remove('completed', 'current');
                step.querySelector('.step-label').textContent = 'Waiting';
            }
        });
    
        lines.forEach((line, index) => {
            if (index < currentDay - 1) {
                line.classList.add('complete');
            } else {
                line.classList.remove('complete');
            }
        });
    }

    function handleFailedCheckIn() {
        Swal.fire({
            icon: 'error',
            title: 'Already Checked In',
            text: 'Come back tomorrow for more rewards!',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        disableCheckInButton();
    }

    function disableCheckInButton() {
        checkInButton.disabled = true;
        checkInButton.innerHTML = 'Already Checked In Today';
        checkInButton.classList.add('btn-secondary');
        checkInButton.classList.remove('btn-primary');
    }

    function updateNextReward(points) {
        const nextRewardElement = document.getElementById('next-reward');
        if (nextRewardElement) {
            nextRewardElement.textContent = points;
        }
    }

    function updateStreak(streak) {
        const streakElement = document.getElementById('check-in-streak');
        if (streakElement) {
            streakElement.textContent = `Current Streak: ${streak} day${streak !== 1 ? 's' : ''}`;
        }
    }

    function updateTotalPoints(newPoints) {
        // Update any points displays on the page
        const pointsDisplays = document.querySelectorAll('.points-display');
        pointsDisplays.forEach(display => {
            const currentPoints = parseInt(display.textContent.replace(/,/g, ''));
            display.textContent = (currentPoints + newPoints).toLocaleString();
        });
    }
});