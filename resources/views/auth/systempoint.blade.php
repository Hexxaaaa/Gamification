<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pointplay Rewards Session</title>
  <link rel="stylesheet" href="{{ asset('css/rewards.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    </head>
    <body>
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand" href="#">
            <img src="{{ url('gallery/logopointplay.png') }}" alt="PointPlay Logo" height="40">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Tasks</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Rewards</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Leaderboard</a>
              </li>
            </ul>
            <div class="d-flex align-items-center">
              <img src="{{ url('gallery/userfoto.png') }}" alt="User Profile" class="rounded-circle me-2" height="40">
              <div>
                <span class="d-block fw-bold">Anon User</span>
                <small>21,870 Pts</small>
              </div>
            </div>
          </div>
        </div>
      </nav>
      <div class="container mt-4" style="width: 80">
        <div class="row justify-content-between">
          <div class="col-md-6">
            <div class="profile-card">
              <img src="{{ url('gallery/userfoto.png') }}" alt="User Avatar" class="rounded-circle mb-3">
              <h5>Anon User</h5>
              <p class="text-muted mb-1">Rank Progression</p>
              <p>🎉 Congratulations! You've leveled up from <strong>Newbie</strong> to <strong>Ultra Violet!</strong></p>
              <div>
                <a href="#" class="me-3 text-decoration-none">
                  <img src="{{ url('gallery/instagram.png') }}"  style="width: 20px"> @Username
                </a>
                <a href="#" class="text-decoration-none">
                    <img src="{{ url('gallery/fb.png') }}"  style="width: 20px"> @Username  
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="balance-card">
              <h3 class="display-5 text-warning">800</h3>
              <p class="fw-bold">Your Balance</p>
              <small>Earn more points, redeem exciting gifts, and enjoy your TBH experience.</small>
            </div>
          </div>
        </div>
      </div>        
  <div class="voucher-section">
    <div class="container">
      <h2 class="text-center mb-5">Unlock exclusive perks and maximize your experience.</h2>
      <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
          <div class="voucher-card text-center">
            <h5>Starbuck</h5>
            <p>Total Sale: Rp 15,000</p>
            <p>Points Exchanged: 3,000</p>
            <button class="btn btn-success w-100">Redeem</button>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="voucher-card text-center">
            <h5>Richeese Factory</h5>
            <p>Total Sale: Rp 50,000</p>
            <p>Points Exchanged: 8,000</p>
            <button class="btn btn-warning w-100">Redeem</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="container points-history">
    <h3 class="mb-4">Points History</h3>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Store</th>
            <th>Reward Type</th>
            <th>Date</th>
            <th>Points Redeemed</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>KFC</td>
            <td>Discount Voucher</td>
            <td>Okt 12, 2024</td>
            <td>+40 Points</td>
          </tr>
          <tr>
            <td>McDonald's</td>
            <td>Discount Voucher</td>
            <td>Okt 12, 2024</td>
            <td>+50 Points</td>
          </tr>
          <tr>
            <td>Burger King</td>
            <td>Discount Voucher</td>
            <td>Okt 12, 2024</td>
            <td>+90 Points</td>
          </tr>
          <tr>
            <td>Starbuck</td>
            <td>Discount Voucher</td>
            <td>Okt 12, 2024</td>
            <td>+80 Points</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  
  <footer>

  </footer>

  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
