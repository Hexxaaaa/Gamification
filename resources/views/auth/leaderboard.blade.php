<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leaderboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/leaderboard.css') }}">
</head>
<body>
  <!-- Navbar -->
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
          <span class="me-3">Anon User</span>
          <span class="badge bg-primary">21,870 Pts</span>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container mt-5 col-md-11">
    <div class="row">
      <!-- Left Section -->
      <div class="col-md-8">
        <div class="leaderboard-card shadow-sm bg-white " style="border-radius: 30px; border: 2px solid black;">
          <h2 class="text-left">Leaderboard and Badge</h2>
          <p class="text-left col-6">Track your rank and see how you stack up against others this week</p><br>
          <div class="leaderboard-bar">
            <div class="bar" style="height: 100px;">
              <span class="badge bg-secondary rounded-pill mt-2">1,000</span>
             <div class="profile-circle" style="margin-top: 50px; width: 80px; height: 80px; border-radius: 50%; border: 4px solid #55C25A; overflow: hidden;">
                <img src="{{ url('gallery/userfoto.png') }}" alt="logosatu" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
            </div>
            <div class="bar" style="height: 290px;">
              <span class="badge bg-secondary rounded-pill mt-2">2,900</span>
              <div class="profile-circle" style="margin-top: 250px; width: 80px; height: 80px; border-radius: 50%; border: 4px solid black; overflow: hidden;">
                <img src="{{ url('gallery/userfoto.png') }}" alt="logosatu" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
            </div>
            <div class="bar" style="height: 230px;">
              <span class="badge bg-secondary rounded-pill">2,300</span>
              <div class="profile-circle" style="margin-top: 180px; width: 80px; height: 80px; border-radius: 50%;  border: 4px solid #578EE4; overflow: hidden;">
                <img src="{{ url('gallery/userfoto.png') }}" alt="logosatu" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
            </div>
          </div>
          <br>
          <div class="badge-reward">
            <h5>Badge Reward</h5>
            <p>Congratulations to our top scorer of the week!</p>
          </div>
        </div>
      </div>
      <!-- Right Section -->
     <div class="col-md-4">
        <div class="leaderboard-list shadow-sm p-3" style="border-radius:30px; border: 2px solid black;">
          <h5 class="text-left">Leaderboard List</h5>
          <p class="text-left" style="font-family: 'Poppins">Visualize your weekly progress</p>
          <ul class="list-group gap-5">
            <li class="list-group-item d-flex justify-content-between align-items-center" style="border-radius:30px; border: 2px solid #89A8B2;">
                <div>
                  <img src="{{ url('gallery/userfoto.png') }}" class="rounded-circle me-2" alt="Avatar" style="width: 40px">
                  <span>Anon User</span>
                </div>
                <div class="d-flex align-items-center">
                  <span class="badge bg-primary rounded-pill me-2">2,900 Points</span>
                  <img src="{{ url('gallery/coin.png') }}" alt="Coin Icon" style="width: 32px; height: 30px;">
                </div>
              </li>              
              <li class="list-group-item d-flex justify-content-between align-items-center"style="border-radius:30px; border: 2px solid #89A8B2;">
                <div>
                  <img src="{{ url('gallery/userfoto.png') }}" class="rounded-circle me-2" alt="Avatar" style="width: 40px">
                  <span>Anon User</span>
                </div>
                <div class="d-flex align-items-center">
                  <span class="badge bg-primary rounded-pill me-2">2,900 Points</span>
                  <img src="{{ url('gallery/coin.png') }}" alt="Coin Icon" style="width: 32px; height: 30px;">
                </div>
              </li>  
              <li class="list-group-item d-flex justify-content-between align-items-center"style="border-radius:30px; border: 2px solid #89A8B2;">
                <div>
                  <img src="{{ url('gallery/userfoto.png') }}" class="rounded-circle me-2" alt="Avatar" style="width: 40px">
                  <span>Anon User</span>
                </div>
                <div class="d-flex align-items-center">
                  <span class="badge bg-primary rounded-pill me-2">2,900 Points</span>
                  <img src="{{ url('gallery/coin.png') }}" alt="Coin Icon" style="width: 32px; height: 30px;">
                </div>
              </li>  
              <li class="list-group-item d-flex justify-content-between align-items-center" style="border-radius:30px; border: 2px solid #89A8B2;">
                <div>
                  <img src="{{ url('gallery/userfoto.png') }}" class="rounded-circle me-2" alt="Avatar" style="width: 40px">
                  <span>Anon User</span>
                </div>
                <div class="d-flex align-items-center">
                  <span class="badge bg-primary rounded-pill me-2">2,900 Points</span>
                  <img src="{{ url('gallery/coin.png') }}" alt="Coin Icon" style="width: 32px; height: 30px;">
                </div>
                <li class="list-group-item d-flex justify-content-between align-items-center" style="border-radius:30px; border: 2px solid #89A8B2;">
                    <div>
                      <img src="{{ url('gallery/userfoto.png') }}" class="rounded-circle me-2" alt="Avatar" style="width: 40px">
                      <span>Anon User</span>
                    </div>
                    <div class="d-flex align-items-center">
                      <span class="badge bg-primary rounded-pill me-2">2,900 Points</span>
                      <img src="{{ url('gallery/coin.png') }}" alt="Coin Icon" style="width: 32px; height: 30px;">
                    </div>
                  </li>  
          </ul>
        </div>
      </div>
    </div>
  </div>
  <br><br><br>
  <div id="badgeContainer" class="container badge-container hidden">
    <h3 class="text-center mb-4">Badge Reward</h3>
    <div class="row justify-content-center">
      <!-- Badge 1 -->
      <div class="col-6 col-sm-4 col-md-2 mb-3 badge-box-container">
        <div class="badge-box text-center p-4 border rounded shadow" style="background-color: #2C3034;">
          <h6 style="font-family: 'Poppins'; color: white;">Level 1</h6>
          <div class="icon mt-4" style="background-color: transparent;">
            <img src="{{ url('gallery/coindaily.png') }}" alt="logocoin" style="width: 50px; background-color: transparent; border: none;">
        </div><br>
          <p style="color: white;">750</p>
          <button class="btn btn-secondary btn-sm bg-zinc-200" disabled>Collection</button>
        </div>
      </div>
      <!-- Badge 2 -->
      <div class="col-6 col-sm-4 col-md-2 mb-3 badge-box-container">
        <div class="badge-box text-center p-4 border rounded shadow" style="background-color: #55C25A">
          <h6 style="color: blue">Level 2</h6>
          <div class="icon mt-4" style="background-color: transparent;">
            <img src="{{ url('gallery/coindaily.png') }}" alt="logocoin" style="width: 50px; background-color: transparent; border: none;">
        </div><br>
          <p style="color: white;">750</p>
          <button class="btn btn-primary btn-sm">Claim</button>
        </div>
      </div>
      <!-- Badge 3 -->
      <div class="col-6 col-sm-4 col-md-2 mb-3 badge-box-container">
        <div class="badge-box text-center p-4 border rounded shadow" style="background-color: #55C25A">
          <h6>Level 3</h6>
          <div class="icon mt-4" style="background-color: transparent;">
            <img src="{{ url('gallery/coindaily.png') }}" alt="logocoin" style="width: 50px; background-color: transparent; border: none;">
        </div><br>
          <p style="color: white;">1000</p>
          <button class="btn btn-secondary btn-sm" disabled style="background-color: #2C3034"><img src="{{ url('gallery/padlock.png') }}" alt="logokunci" style="width: 25px"></button>
        </div>
      </div>
      <!-- Badge 4 -->
      <div class="col-6 col-sm-4 col-md-2 mb-3 badge-box-container">
        <div class="badge-box text-center p-4 border rounded shadow" style="background-color: #55C25A">
          <h6>Level 4</h6>
          <div class="icon mt-4" style="background-color: transparent;">
            <img src="{{ url('gallery/coindaily.png') }}" alt="logocoin" style="width: 50px; background-color: transparent; border: none;">
        </div><br>
          <p style="color: white;">2000</p>
          <button class="btn btn-secondary btn-sm" disabled style="background-color: #2C3034"><img src="{{ url('gallery/padlock.png') }}" alt="logokunci" style="width: 25px"></button>
        </div>
      </div>
      <!-- Badge 5 -->
      <div class="col-6 col-sm-4 col-md-2 mb-3 badge-box-container">
        <div class="badge-box text-center p-4 border rounded shadow" style="background-color: #2C3034;">
          <h6 style="color: white">Level 5</h6>
          <div class="icon mt-4" style="background-color: transparent;">
            <img src="{{ url('gallery/coindaily.png') }}" alt="logocoin" style="width: 50px; background-color: transparent; border: none;">
        </div><br>
          <p style="color: white;">3000</p>
          <button class="btn btn-secondary btn-sm" disabled style="background-color: #2C3034"><img src="{{ url('gallery/padlock.png') }}" alt="logokunci" style="width: 25px"></button>
        </div>
      </div>
      <!-- Badge 10 -->
      <div class="col-12 col-md-4 mb-3 badge-box-container">
        <div class="badge-box text-center p-5 border rounded shadow bg-warning">
          <h6>Level 10</h6>
          <div class="icon mt-4" style="background-color: transparent;">
            <img src="{{ url('gallery/coindaily.png') }}" alt="logocoin" style="width: 50px; background-color: transparent; border: none;">
        </div><br>
          <p style="color: white;">1.000.000</p>
          <button class="btn btn-secondary btn-sm" disabled style="background-color: #2C3034"><img src="{{ url('gallery/padlock.png') }}" alt="logokunci" style="width: 25px"></button>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
<footer class="footer text-center py-4">
    <div class="container">
      <div class="social-icons">
        <a href="#" target="_blank" class="icon-link">
         <img src="{{ asset('gallery/twitter.png') }}" alt="logotwitter" style="width: 15px">
        </a>
        <a href="#" target="_blank" class="icon-link">
            <img src="{{ asset('gallery/fb.png') }}" alt="logofb" style="width: 15px">
        </a>
        <a href="#" target="_blank" class="icon-link">
            <img src="{{ asset('gallery/youtube.png') }}" alt="logofb" style="width: 15px">
        </a>
      </div>
      <div class="help-button mt-3">
        <a href="/bantuan" class="btn btn-help">Butuh Bantuan?</a>
      </div>
    </div>
  </footer>
  <script src="{{ asset('js/leaderboard.js') }}"></script>
</body>
</html>
