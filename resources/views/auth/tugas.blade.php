<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Card Layout with Bootstrap</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/tugas.css') }}">

</head>
<body>
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
  <div class="container card-container">
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <article class="card-article">
          <img src="{{ asset('gallery/Agaklaen.jpeg') }}" alt="image" class="card-img">
        </article>
      </div>
      <div class="col-md-6 col-lg-4">
        <article class="card-article">
          <img src="{{ asset('gallery/bilaesokibu.jpeg') }}" alt="image" class="card-img">
        </article>
      </div>
      <div class="col-md-6 col-lg-4">
        <article class="card-article">
          <img src="{{ asset('gallery/jendelaseribusungai.jpeg') }}" alt="image" class="card-img">
           
        </article>
      </div>
    </div>
  </div>
  
  <div class="container my-5">
    <!-- Search bar -->
    <div class="container">
      <div class="row justify-content-center mb-4">
          <div class="col-12 col-sm-8 col-md-6 col-lg-5">
              <form class="d-flex">
                  <input type="text" class="form-control me-2" placeholder="Search Videos">
                  <button class="btn btn-danger" type="submit">Search</button>
              </form>
          </div>
      </div>
  </div>
    <!-- Title -->
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h6 class="text-muted">TOTAL IS IN QUEUE</h6>
            <h2 style="font-family: 'Poppins', font-weight:500;">Continue Watching</h2>
        </div>
    </div>

    <!-- Video Cards -->
    <div class="row text-center">
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist2.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist3.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist2.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist4.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist3.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container py-5">
  <h2 class="text-center mb-4">Film Poster Style Cards</h2>
  <div class="row justify-content-center">
    <!-- Card 1 -->
    <div class="col-md-3 mb-4">
      <div class="card border-0">
        <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="Image 1">
        <h5 class="card-title">Movie Title 1</h5>
        <p class="card-text">Description for Movie 1.</p>
      </div>
    </div>
    <!-- Card 2 -->
    <div class="col-md-3 mb-4">
      <div class="card border-0">
        <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="Image 2">
        <h5 class="card-title">Movie Title 2</h5>
        <p class="card-text">Description for Movie 2.</p>
      </div>
    </div>
    <!-- Card 3 -->
    <div class="col-md-3 mb-4">
      <div class="card border-0">
        <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="Image 3">
        <h5 class="card-title">Movie Title 3</h5>
        <p class="card-text">Description for Movie 3.</p>
      </div>
    </div>
    <!-- Card 4 -->
    <div class="col-md-3 mb-4">
      <div class="card border-0">
        <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="Image 4">
        <h5 class="card-title">Movie Title 4</h5>
        <p class="card-text">Description for Movie 4.</p>
      </div>
    </div>
  </div>
</div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>