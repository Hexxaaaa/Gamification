<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gamification Tanpa Batas</title>
  <link href="{{ asset('css/index.css') }}" rel="stylesheet">
</head>
<body>
  <header>
    <div class="logo">
      <img src="{{ url('gallery/logopointplay.png') }}" class="logoatas">
    </div>
  </header>

  <main class="container">
    <div class="content">
      <h1>Gamification Tanpa Batas</h1>
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
  </footer>
</body>
</html>
