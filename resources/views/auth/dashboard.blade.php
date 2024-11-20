<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Rewards Page</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
  <header class="header">
    <div class="logo">Logolipsum</div>
    <nav class="nav">
      <a href="#tasks">Tasks</a>
      <a href="#rewards">Rewards</a>
      <a href="#insights">Insights</a>
    </nav>
    <div class="user-menu">
      <span>Hi, User</span>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="hero-text">
        <h1 class="katapertama">Earn Points</h1>
        <h1>Rewards Easily</h1>
        <h1>and Enjoy</h1>
        <p>Complete tasks, gain points, and unlock incredible rewards to keep your engagement journey exciting and fulfilling.</p>
        <button>Get Started</button>
      </div>
      <div class="points">
        <div class="user-info">
          <img src="{{ url('gallery/userfoto.png') }}" alt="User Avatar">
          <p>Anna User</p>
          <span>anna@example.com</span>
        </div>
        <div class="points-balance">
          <h2>2,688,75638</h2>
          <button>Redeem</button>
        </div>
      </div>
    </section>

    <section class="insights">
      <h2>Insights that elevate your engagement.</h2>
      <table>
        <tr>
          <th>Platform</th>
          <th>Tasks</th>
          <th>Points</th>
        </tr>
        <tr>
          <td>System</td>
          <td>400</td>
          <td>8,200</td>
        </tr>
      </table>
    </section>

    <section class="featured">
      <h2>Featured Video</h2>
      <div class="videos">
        <div class="video">Video 1</div>
        <div class="video">Video 2</div>
        <div class="video">Video 3</div>
      </div>
    </section>

    <section class="summary">
      <h2>Gamification platform highlights</h2>
      <ul>
        <li>90+ Integrations</li>
        <li>700+ Engaged users</li>
        <li>100% Transparent</li>
      </ul>
    </section>
  </main>

  <footer>
    <p>Ready to level up your engagement journey?</p>
  </footer>
</body>
</html>
