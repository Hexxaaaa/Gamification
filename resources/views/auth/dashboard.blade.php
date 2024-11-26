  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>PointPlay</title>
      <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <script src="{{ asset('js/dashboard.js') }}"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  </head>
  <body>
      <header class="header">
          <div class="logo align-top" style="50%">
            <img src="{{ url('gallery/brandlogo.png') }}" class="logobrand">
          </div>
          <nav class="nav">
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">Tasks</a></li>
              <li><a href="#">Rewards</a></li>
              <li><a href="#">Leaderboard</a></li>
            </ul>
          </nav>
          <div class="user-info">
            <a href="" ><img src="{{ url('gallery/bell.png') }}" class="notification"></a>
            <div class="profile">
              <a href="{{ route('profile') }}">
              <img src="{{ url('gallery/userfoto.png') }}" class="profileheader">
              </a>
              <span class="points ms-2 fw-bold">21,870 Pts</span>
            </div>
          </div>
      
        </header>
      <main class="mainutama">
          <section class="hero">
              <div class="hero-text">
                <br>
                <div class="display-2 col-md-6 offset-1" style="width=40%">
                  <h1>
                  <b>Earn Points</b> Rewards Easily and enjoy
                </h1>
                </div>
                  
                  <br>
                  <div class="bawahheader col-md-6 col-lg-12 offset-1">
                    <p>Complete tasks, collect points, and unlock exclusive rewards to keep your engagement fun and rewarding</p>
                  </div>
                  
                  <a class="btn btn-primary col-md-2 offset-1" href="#" role="button">Get Started</a>
                  <br><br><div class="partners">
                    <img src="{{ url('gallery/axon.png') }}" alt="Axon Airlines">
                    <img src="{{ url('gallery/jetstar.png') }}" alt="Jetstar">
                    <img src="{{ url('gallery/qantas.png') }}" alt="Qantas">
                    <img src="{{ url('gallery/alitalia.png') }}" alt="Alitalia">
                    </div>
              </div>
              
              <br>
              <div class="reward-card">
                  <div class="user-card">
                    <a href="{{ route('profile') }}">
                      <img src="{{ url('gallery/userfoto.png') }}" alt="User Profile"  >
                    </a>
                      <div>
                          <p>Anon User</p>
                          <p>User543@gmail.com</p>
                      </div>
                  </div>
                  <div class="points2">
                      <p class="user">Total Points</p>
                      <h2 class="pointuser">2,686,75638</h2>
                      <p class="tanggaluser">April 22, 2024</p>
                  </div>
                  <div class="tomboltukar">
                  <a href=""><img src="{{ url('gallery/coin.png') }}" class="koin">REDEEM POINTS</button></a>
              </div>
              </div>
              <div class="container">
                  <div class="title">
                    <h1>PROGRESS INSIGHTS</h1>
                  </div>
                  <div class="tittle2">
                  <h1>Insights that elevate</h1>
                  <h1>your engangement.</h1>
              </div>
                  <div class="description">
                    Track user participation and progress with real-time analytics designed to optimize engagement and maximize rewards, creating a dynamic and interactive experience.
                  </div>
                  <div class="table">
                    <div class="platform">
                      <img src="{{ url('gallery/logobrand.png') }}" alt="Logo">
                    </div>
                    <div><img src="{{ url('gallery/heart.png') }}" class="insightbtn">400</div>
                    <div><img src="{{ url('gallery/comment.png') }}" class="insightbtn">50</div>
                    <div><img src="{{ url('gallery/share.png') }}" class="insightbtn">8K</div>
                    <div class="score"> Total Score : 8,450</div>
                  </div>
                </div>
              </div>
          </section>
      </main>
    <br>
      
      <br>
      <div class="listgambar">
          <div class="list">
              <div class="slide"><img src="{{ url('gallery/pengantiniblis.jpeg') }}" alt="Image 1"></div>
              <div class="slide"><img src="{{ url('gallery/perayaanmati.jpeg') }}" alt="Image 2"></div>
              <div class="slide"><img src="{{ url('gallery/bilaesokibu.jpeg') }}" alt="Image 3"></div>
              <div class="slide"><img src="{{ url('gallery/Agaklaen.jpeg') }}" alt="Image 4"></div>
              <div class="slide"><img src="{{ url('gallery/jendelaseribusungai.jpeg') }}" alt="Image 5"></div>
          </div>
          <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
          <button class="next" onclick="moveSlide(1)">&#10095;</button>
      </div>
  <br><br><br>
  <div class="footer">
      
  <h1 class="tulisakhir">OUR MISION</h1>
  <h3>Gamification Platform</h3>
  <h3>highlight</h3>
  </div><br>
  <div class="tulisakhir2">
    <p>Complete missions, engage with content, and earn</p>
    <p>rewards that motivate and inspire</p>
  </div><br><br>
  <div class="angkafooter">
  <h3>90+</h3>
  <h3>700+</h3>
  <h3>100%</h3>
  </div>
  <div class="angkafooter2">
      <p>highly rewarding mission</p>
      <p>engaged users worldwide</p>
      <p>Transparent and fair challenges</p>
  </div>
  <div class="container">
    <div class="content">
      <h1>Ready to level up your engagement journey</h1><br>
      <p>
        Empower users with exciting challenges, rewarding missions, and seamless progress tracking to boost participation and motivation.
      </p>
    </div>
    <div class="social-icons">
      <a href="#" aria-label="Youtube"><img src="{{ url('gallery/youtube.png') }}" class="icon"></a>
      <a href="#" aria-label="Facebook"><img src="{{ url('gallery/fb.png') }}" class="icon"></a>
      <a href="#" aria-label="Twitter"><img src="{{ url('gallery/twitter.png') }}" class="icon"></a>
      <a href="#" aria-label="Instagram"><img src="{{ url('gallery/instagram.png') }}"class="icon"></a>
      <a href="#" aria-label="LinkedIn"><img src="{{ url('gallery/linkedin.png') }}"class="icon"></a>
    </div>
  </div>
  </body>
  </html>
