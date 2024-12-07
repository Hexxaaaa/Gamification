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
      <div class="bagianatas"  style="background-color: #E5EDFF">
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
          <div class="container">
            <a class="navbar-brand" href="#">
              <img src="{{ url('gallery/logopointplay.png') }}" alt="logobrand" style="width: 100px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-1" id="navbarNav">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="/dashboard">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/tasks">Tasks</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/rewards">Rewards</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/leaderboard">Leaderboard</a>
                </li>
              </ul>
              <div class="d-flex align-items-center">
                <span class="me-3">Anon User</span>
                <span class="badge bg-primary">21,870 Pts</span>
              </div>
            </div>
          </div>
        </nav>
      
      <div class="container mt-5">
        <div class="row">
            <!-- Profile Section -->
            <div class="col-md-8">
                <div class="profile-card d-flex align-items-center" style="background-color: #000d71">
                    <img src="{{ asset('gallery/userfoto.png') }}" class="rounded-circle me-3" alt="User Image" style="width: 80px">
                    <div>
                        <h5 class="text-white">Anon User</h5>
                        <p class="mb-1 text-white">
                            🎉 Congratulations! You've leveled up from 
                            <a href="#" class="text-decoration-none text-primary">Newbie</a> to 
                            <a href="#" class="text-decoration-none text-primary">Ultra Violet</a>!
                        </p>
                        <div class="d-flex">
                            <a href="#" class="text-decoration-none me-3">@YusufLenang</a>
                            <a href="#" class="text-decoration-none">@Yusuf32</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Balance Section -->
            <div class="col-md-4"style="background-color: #E5EDFF">
                <div class="balance-card">
                  <img src="{{ asset('gallery/coindaily.png') }}" alt="" width="40px">
                    <div class="balance">800</div>
                    <p>Your Balance</p>
                    <p class="text-muted">
                        Earn more points, redeem exciting gifts, and enjoy your TBH experience
                    </p>
                </div>
            </div>
        </div>
      </div>
        <!-- Daily Rewards Section -->
        <div class="daily-rewards mt-5" style="background-color: #E5EDFF">
            <h3 style="font-family: 'Poppins',sans-serif, font-weight: 500; font-style: normal; font-size: 65px; color: #007DFC ;">Daily Rewards</h3>
            <p style="font-family: 'Poppins',sans-serif, font-weight: 100; font-style: normal;">Watch Videos Daily, Complete Missions, and Earn Rewards!</p>
            <p>Collect up to <strong> <img src="{{ asset('gallery/kado.png') }}"  style="width: 22px;">102,400 points</strong></p>
            <a class="btn btn-primary" href="#" style="border-radius: 200px">Check-in</a>
            <br>
        </div>
      </div>
    </div>
<br>
        <!-- Progress Section -->
        <div class="progress-container">
          <div class="progress-step complete">
              <div class="progress-circle complete">
                <img src="{{ asset('gallery/verified.png') }}" alt="">
              </div>
              <div>100% Complete</div>
              <div class="step-points">Hari-1 50 points</div>
          </div>
          <div class="line complete"></div>
          <div class="progress-step complete">
            <div class="progress-circle complete">
              <img src="{{ asset('gallery/verified.png') }}" alt="">
            </div>
            <div>100% Complete</div>
            <div class="step-points">Hari-2 100 points</div>
        </div>
        <div class="line complete"></div>
          <div class="progress-step in-progress">
              <div class="progress-circle in-progress">
                <img src="{{ asset('gallery/verifiedblue.png') }}" alt="">
              </div>
              <div>60% in Progress</div>
              <div class="step-points">Hari-3 150 points</div>
          </div>
          <div class="line in-progress"></div>
          <div class="progress-step waiting">
              <div class="progress-circle waiting">
                <img src="{{ asset('gallery/verifiedabu.png') }}" alt="">
              </div>
              <div class="step-label">Waiting</div>
              <div class="step-points">Hari-4 200 points</div>
          </div>
          <div class="line waiting"></div>
      </div>
  
      <div class="progress-container mt-5">
        <div class="progress-step waiting">
            <div class="progress-circle waiting">
              <img src="{{ asset('gallery/verifiedabu.png') }}" alt="">
            </div>
            <div class="step-label">Waiting</div>
            <div class="step-points">Hari-5 250 points</div>
        </div>
        <div class="line waiting"></div>
        <div class="progress-step waiting">
            <div class="progress-circle waiting">
              <img src="{{ asset('gallery/verifiedabu.png') }}" alt="">
            </div>
            <div class="step-label">Waiting</div>
            <div class="step-points">Hari-6 300 points</div>
        </div>
        <div class="line waiting"></div>
        <div class="progress-step waiting">
            <div class="progress-circle waiting">
              <img src="{{ asset('gallery/verifiedabu.png') }}" alt="">
            </div>
            <div class="step-label">Waiting</div>
            <div class="step-points">Hari-7 350 points</div>
        </div>
        <div class="line waiting"></div>
    </div>

      
      
    <div class="voucher-section">
      <div class="container">
        <h2 class="text-center mb-4">Unlock exclusive perks and maximize your experience.</h2>
        <div class="row justify-content-center">
          <div class="col-12 col-md-4">
            <div class="voucher-card text-center p-3" style="background: #016646; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
              <img src="{{ url('gallery/starbucks.png') }}" class="rounded-circle mb-2" style="width: 60px; height: 60px;" />
              <h5 class="text-white" style="font-family: 'Poppins'; font-size: 1rem;">Starbucks</h5>
              <p class="text-white" style="font-family: 'Poppins'; font-size: 0.9rem;">Total Sale: <strong>Rp 15,000</strong></p>
              <p class="text-white" style="font-family: 'Poppins'; font-size: 0.9rem;">Points Exchanged: <strong>3,000</strong></p>
              <button class="btn btn-light w-100 fw-bold" style="font-size: 0.9rem; color: blue;">Redeem</button>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="voucher-card text-center p-3" style="background: #FF9933; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
              <img src="{{ url('gallery/logoricheese.png') }}" class="rounded-circle mb-2" style="width: 60px; height: 60px;" />
              <h5 class="text-white" style="font-size: 1rem;">Richeese Factory</h5>
              <p class="text-white" style="font-size: 0.9rem;">Total Sale: <strong>Rp 50,000</strong></p>
              <p class="text-white" style="font-size: 0.9rem;">Points Exchanged: <strong>8,000</strong></p>
              <button class="btn btn-light w-100 fw-bold" style="font-size: 0.9rem; color: blue;">Redeem</button>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="voucher-card text-center p-3" style="background: linear-gradient(135deg, #85d8ce, #7cc6fe); border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
              <img src="{{ url('gallery/KFC.png') }}" class="rounded-circle mb-2" style="width: 60px; height: 60px;" />
              <h5 class="text-white" style="font-size: 1rem;">KFC</h5>
              <p class="text-white-50" style="font-size: 0.9rem;">Total Sale: <strong>Rp 100,000</strong></p>
              <p class="text-white-50" style="font-size: 0.9rem;">Points Exchanged: <strong>20,000</strong></p>
              <button class="btn btn-light w-100 fw-bold" style="font-size: 0.9rem; color: blue;">Redeem</button>
            </div>
          </div>
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

  <script src="{{ asset('js/rewards.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
