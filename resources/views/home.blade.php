<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gamification Tanpa Batas</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/index.css') }}" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <div class="logo">
      <img src="{{ url('gallery/logopointplay.png') }}" class="logoatas">
    </div>
  </header>

  <main class="container">
    <div class="content">
      <button style="border-radius: 20px; background-color: #E5EDFF; color: #4F7DF3;">Dapatkan semua hadiah yang ada</button>
     <b><h1  class="col-4"style="font-size: 50px" >Gamification Tanpa Batas</h1></b>
      <p>Kenapa harus website kami? Karena kami menawarkan berbagai tugas yang dapat diselesaikan dan akan mendapatkan poin yang bisa ditukar dengan saldo atau kupon.</p>
      <div class="buttons">
        <a href="/login">
          <button class="primary">Masuk</button>
        </a>
        <a href="/register">
          <button class="secondary">Daftar Sekarang</button>
        </a>
      </div>
    </div>
    <div class="image">
      <img src="{{ url('gallery/index.png') }}" width="500px" alt="gambar-orangduduk">
    </div>
  </main>

  <footer>
    <div class="col-md-6">
      <div class="reward-logo mt-4 col-12 gap-5">
          <img src="{{ asset('gallery/axon.png') }}" alt="Axon">
          <img src="{{ asset('gallery/jetstar.png') }}" alt="Jetstar">
          <img src="{{ asset('gallery/expedia.png') }}" alt="Expedia">
          <img src="{{ asset('gallery/qantas.png') }}" alt="Qantas">
          <img src="{{ asset('gallery/alitalia.png') }}" alt="Alitalia">
      </div>
  </div>
  </footer>
</body>
<style>
  *{
  font-family: 'Poppins',serif; font-weight:500; font-style: normal;
}
</style>
</html>
