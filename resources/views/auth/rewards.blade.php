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
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link" href="/dashboard">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/task">Tasks</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/rewards">Rewards</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/leaderboard">Leaderboard</a>
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
      <div class="profil-container mt-4" >
        <div class="row justify-content-between">
          <div class="col-md-6">
            <div class="profile-card"style="border-radius:30px; border: 2px solid black;">
              <img src="{{ url('gallery/userfoto.png') }}" alt="User Avatar" class="rounded-circle mb-3" style=" border-radius: 50%; border: 4px solid rgb(236, 230, 230);">
              <h5>Anon User</h5>
              <p class="text-muted mb-1">Rank Progression</p>
              <p>🎉 Congratulations! You've leveled up from <strong>Newbie</strong> to <strong>Ultra Violet!</strong></p>
              <div>
                <a href="#" class="me-3 text-decoration-none">
                  <img src="{{ url('gallery/instagram.png') }}"  style="width: 20px" > @Username
                </a>
                <a href="#" class="text-decoration-none">
                    <img src="{{ url('gallery/fb.png') }}"  style="width: 20px"> @Username  
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-4">  
            <div class="balance-card" style="border-radius:30px; border: 2px solid black;">
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
      <div id="voucherCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="voucher-card text-center p-4" style="background: #016646 ;">
              <img src="{{ url('gallery/starbucks.png') }}" class="rounded-circle mb-3" />
              <h5 class="text-white" style="font-family: 'Poppins' ">Starbucks</h5>
              <p class="text-white" style="font-family: 'Poppins'">Total Sale: </p>
              <p><strong>Rp 15,000</strong></p>
              <p class="text-white" style="font-family: 'Poppins'">Points Exchanged: <br></p>
              <p><strong>3,000</strong></p>
              <button class="btn btn-light w-100 fw-bold" style="color: blue">Redeem</button>
            </div>
          </div>
          <div class="carousel-item">
            <div class="voucher-card text-center p-4" style="background:#FF9933;">
              <img src="{{ url('gallery/logoricheese.png') }}" class="rounded-circle mb-3" />
              <h5 class="text-white">Richeese Factory</h5>
              <p class="text-white">Total Sale: </p>
              <p><strong>Rp 50,000</strong></p>
              <p class="text-white">Points Exchanged: </p>
              <p><strong>8,000</strong></p>
              <button class="btn btn-light w-100 fw-bold" style="color: blue">Redeem</button>
            </div>
          </div>
          <div class="carousel-item">
            <div class="voucher-card text-center p-4" style="background: linear-gradient(135deg, #85d8ce, #7cc6fe);">
              <img src="{{ url('gallery/KFC.png') }}" class="rounded-circle mb-3" />
              <h5 class="text-white">KFC</h5>
              <p class="text-white-50">Total Sale: </p>
              <p><strong>Rp 100,000</strong></p>
              <p class="text-white-50">Points Exchanged: </p>
              <p><strong>20,000</strong></p>
              <button class="btn btn-light w-100 fw-bold" style="color: blue">Redeem</button>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#voucherCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#voucherCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>      
    </div>
  </div>

  <div class="container points-history-container">
    <div class="row align-items-center">
        <div class="col-lg-8 col-md-12">
            <h3>Points History</h3>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-secondary" type="button">
                    <img src="{{ url('gallery/settings.png') }}" style="width: 25px">
                </button>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Store</th>
                        <th scope="col">Reward Type</th>
                        <th scope="col">Date</th>
                        <th scope="col">Points Redeemed</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>KFC</td>
                        <td>Discount Voucher</td>
                        <td>Oct 12, 2024, at 2:20 PM</td>
                        <td class="text-primary">+40 Points</td>
                    </tr>
                    <tr>
                        <td>McDonald's</td>
                        <td>Discount Voucher</td>
                        <td>Oct 12, 2024, at 2:20 PM</td>
                        <td class="text-primary">+50 Points</td>
                    </tr>
                    <tr>
                        <td>Burger King</td>
                        <td>Discount Voucher</td>
                        <td>Oct 12, 2024, at 2:20 PM</td>
                        <td class="text-primary">+90 Points</td>
                    </tr>
                    <tr>
                        <td>Starbuck</td>
                        <td>Discount Voucher</td>
                        <td>Oct 12, 2024, at 2:20 PM</td>
                        <td class="text-primary">+80 Points</td>
                    </tr>
                    <tr>
                        <td>Starbuck</td>
                        <td>Discount Voucher</td>
                        <td>Oct 12, 2024, at 2:20 PM</td>
                        <td class="text-primary">+80 Points</td>
                    </tr>
                    <tr>
                        <td>Starbuck</td>
                        <td>Discount Voucher</td>
                        <td>Oct 12, 2024, at 2:20 PM</td>
                        <td class="text-primary">+80 Points</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-lg-4 col-md-12 illustration">
            <img src="{{ url('gallery/logorewards.png') }}">
        </div>
    </div>
</div>

  
  <footer>

  </footer>

  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
