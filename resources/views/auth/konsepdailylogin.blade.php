<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Badge Rewards</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <div id="notification" class="notification">
    <p>Welcome! Check out your Badge Rewards!</p>
    <button id="closeNotification" class="btn-close btn-close-white"></button>
  </div>

  <!-- Main Content -->
  <div id="badgeContainer" class="container badge-container hidden">
    <h3 class="text-center mb-4">Badge Reward</h3>
    <div class="row justify-content-center">
      <!-- Badge 1 -->
      <div class="col-6 col-sm-4 col-md-2 mb-3">
        <div class="badge-box text-center p-3 border rounded shadow">
          <h6>Badge 1</h6>
          <div class="icon">C</div>
          <p>750</p>
          <button class="btn btn-secondary btn-sm" disabled>Collection</button>
        </div>
      </div>
      <div class="col-6 col-sm-4 col-md-2 mb-3">
        <div class="badge-box text-center p-3 border rounded shadow">
          <h6>Badge 2</h6>
          <div class="icon">C</div>
          <p>750</p>
          <button class="btn btn-primary btn-sm">Claim</button>
        </div>
      </div>
      <div class="col-6 col-sm-4 col-md-2 mb-3">
        <div class="badge-box text-center p-3 border rounded shadow">
          <h6>Badge 3</h6>
          <div class="icon">C</div>
          <p>3000</p>
          <button class="btn btn-secondary btn-sm" disabled>Locked</button>
        </div>
      </div>

      <div class="col-12 col-md-4 mb-3">
        <div class="badge-box text-center p-4 border rounded shadow bg-warning">
          <h6>Badge 10</h6>
          <div class="icon">🏅</div>
          <p>1,000,000</p>
          <button class="btn btn-secondary btn-sm" disabled>Locked</button>
        </div>
      </div>
    </div>
  </div>

  <footer class="text-center py-3 bg-light">
    <p>CompanyName @ 202X. All rights reserved.</p>
  </footer>

  <script src="{{ asset('js/dailyreward.js') }}"></script>
</body>
<style>

.notification {
  position: fixed;
  top: -100px;
  left: 50%;
  transform: translateX(-50%);
  background-color: #007bff;
  color: white;
  padding: 15px 20px;
  border-radius: 5px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 9999;
  transition: top 0.5s ease-in-out;
}

.notification.visible {
  top: 20px;
}

.notification .btn-close {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  cursor: pointer;
  color: white;
}

.notification .btn-close:hover {
  color: #ffcccb;
}


.badge-container {
  opacity: 0;
  transform: translateY(100px);
  transition: opacity 0.5s ease, transform 0.5s ease;
}

.badge-container.visible {
  opacity: 1;
  transform: translateY(0); 
}

.badge-box {
  background-color: #f9f9f9;
}

.badge-box .icon {
  font-size: 2rem;
  margin-bottom: 10px;
  color: #ffd700;
}

</style>
</html>
