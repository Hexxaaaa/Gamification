<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  </head>

  <body>
    <header>
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
    </header>
    <main>
      <div class="container py-5">
        <div class="row align-items-center">
            <!-- Left Section -->
            <div class="col-md-6">
                <h1><b>Earn Points</b><br>Rewards Easily<br>and Enjoy</h1>
                <p>Complete tasks, collect points, and unlock exclusive rewards to keep your engagement fun and rewarding.</p>
                <a href="#" class="btn btn-primary btn-lg">Get Started</a>
                <div class="reward-logo mt-4 col-12 gap-5">
                    <img src="{{ asset('gallery/axon.png') }}" alt="Axon">
                    <img src="{{ asset('gallery/jetstar.png') }}" alt="Jetstar">
                    <img src="{{ asset('gallery/expedia.png') }}" alt="Expedia">
                    <img src="{{ asset('gallery/qantas.png') }}" alt="Qantas">
                    <img src="{{ asset('gallery/alitalia.png') }}" alt="Alitalia">
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-md-6 d-flex justify-content-center">
              <div class="card-custom text-center">
                  <img src="{{ asset('gallery/userfoto.png') }}" alt="User" style="width: 70px">
                  <h5 class="mt-3">Anon User</h5>
                  <p class="text-muted">User543@gmail.com</p>
                  <div class="mt-4">
                      <p class="total-points">2,686,75638</p>
                      <p class="text-muted">April 22, 2024</p>
                  </div>
                  <div class="form-check text-start">
                      <input class="form-check-input" type="radio" name="redeemOptions" id="redeemPoints" checked>
                      <label class="form-check-label" for="redeemPoints">Redeem Points</label>
                  </div>
                  <button class="btn-redeem">Redeem</button>
              </div>
          </div>
      </div>
  </div>
  <div class="container py-5">
    <div class="row justify-content-center g-4">
        <!-- Card Section -->
        <div class="col-lg-10 col-md-12">
            <div class="card-progress">
                <!-- Section Header -->
                <div class="section-header mb-4">
                    <div class="d-flex justify-content-between flex-column flex-md-row">
                        <div class="text-start mb-3 mb-md-0">
                            <h6>PROGRESS INSIGHTS</h6><br>
                            <h2 style="font-size: 2rem">Insights that elevate your engagement.</h2>
                        </div>
                        <div class="text-start col-12 col-md-7 mt-3 mt-md-5 ms-auto">
                            <p>
                                Track user participation and progress with real-time analytics designed to optimize engagement 
                                and maximize rewards, creating a dynamic and interactive experience.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Platform</th>
                                <th><img src="{{ asset('gallery/like.png') }}" alt="logolike" style="width: 20px"></th>
                                <th><img src="{{ asset('gallery/icon2.png') }}" alt="logolike" style="width: 20px"></th>
                                <th><img src="{{ asset('gallery/commentask.png') }}" alt="logolike" style="width: 20px"></th>
                                <th><img src="{{ asset('gallery/sharetask.png') }}" alt="logolike" style="width: 20px"></th>
                                <th><img src="{{ asset('gallery/icon2.png') }}" alt="logolike" style="width: 20px"></th>
                                <th class="table-score">Total Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="platform-logo">
                                    <img src="{{ asset('gallery/logopointplay.png') }}" alt="Logo" style="width: 100px">
                                </td>
                                <td>400</td>
                                <td>34%</td>
                                <td>50</td>
                                <td>34%</td>
                                <td>8K</td>
                                <td class="table-score">8,450</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container mt-5">
  <div id="posterCarousel" class="poster-carousel">
    <!-- Poster 1 -->
    <div class="poster-item active">
      <img src="{{ asset('gallery/bilaesokibu.jpeg') }}" alt="Annabelle">
      <div class="poster-content">
        <span class="badge bg-warning text-dark mb-4">450</span>
      </div>
    </div>

    <!-- Poster 2 -->
    <div class="poster-item">
      <img src="{{ asset('gallery/Agaklaen.jpeg') }}" alt="Other Movie">
      <div class="poster-content">
        <span class="badge bg-warning text-dark mb-4">400</span>
      </div>
    </div>

    <!-- Poster 3 -->
    <div class="poster-item">
      <img src="{{ asset('gallery/jendelaseribusungai.jpeg') }}" alt="Another Movie">
      <div class="poster-content">
        <span class="badge bg-warning text-dark mb-4">320</span>

      </div>
    </div>

    <!-- Poster 4 -->
    <div class="poster-item">
      <img src="{{ asset('gallery/Pengantiniblis.jpeg') }}" alt="Fourth Movie">
      <div class="poster-content">
        <span class="badge bg-warning text-dark mb-4">380</span>
      </div>
    </div>
  </div>

  <!-- Controls -->
  <div class="d-flex justify-content-center mt-3">
    <button class="btn btn-primary me-2" onclick="prevSlide()">Previous</button>
    <button class="btn btn-primary" onclick="nextSlide()">Next</button>
  </div>
</div>
<br><br><br>
<div class="container text-center">
  <h4 class="text-primary mt-4">OUR MISSION</h4>
  <h1 class="fw-bold mt-2">Gamification platform highlights</h1>
  <p class="text-muted">Complete missions, engage with content, and earn rewards that motivate and inspire</p>
  
  <div class="row stats">
    <div class="col-md-4">
      <h3>90+</h3>
      <p>Highly rewarding missions</p>
    </div>
    <div class="col-md-4">
      <h3>700+</h3>
      <p>Engaged users worldwide</p>
    </div>
    <div class="col-md-4">
      <h3>100%</h3>
      <p>Transparent and fair challenges</p>
    </div>
  </div>
</div>
<div class="container mt-5">
  <div class="engagement-section text-start">
    <h6>Try It Now</h6>
    <h3 class="col-11" style="font-size: 50px">Ready to level up your engagement journey</h3>
    <p class="col-5">Empower users with exciting challenges, rewarding missions, and seamless progress tracking to boost participation and motivation.</p>
    <div class="container mt-5 text-center">
      <div class="icon d-inline-flex">
        <a href="#" class="me-2"><img src="{{ asset('gallery/youtube.png') }}" alt="YouTube"></a>
        <a href="#" class="me-2"><img src="{{ asset('gallery/facebook.png') }}" alt="Facebook"></a>
        <a href="#" class="me-2"><img src="{{ asset('gallery/twitter.png') }}" alt="Twitter"></a>
        <a href="#"><img src="{{ asset('gallery/instagram.png') }}" alt="Instagram"></a>
      </div>
    </div>
  </div>
  
</div>
    </main>
    <footer>
      <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
  </body>
</html>
