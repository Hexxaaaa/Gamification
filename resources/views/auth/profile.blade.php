<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>userprofile</title>
  <link rel="stylesheet" href="{{ asset ('css/profile.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <ul>
        <li><a href="#"><img src="{{ url('gallery/logopoint.png') }}" alt="logo"> </a></li>
        <li><a href="#"><img src="{{ url('gallery/menu.png') }}" alt="menu"></a></li>
        <li><a href="#"><img src="{{ url('gallery/list.png') }}" alt="listtugas"></a></li>
        <li><a href="#"><img src="{{ url('gallery/reward.png') }}" alt="reward"></a></li>
        <li><a href="#"><img src="{{ url('gallery/statistics.png') }}" alt=""></a></li>
        <li><a href="#"><img src="{{ url('gallery/user.png') }}" alt="listtugas"></a></li>
      </ul>
    </div>
    <div class="main-content">
      <div class="header">
        <h1>Welcome, Kelompok 1</h1>
        <br><br><br><div class="search-bar">
            <input type="search" placeholder="Search">
          <img src="{{ url('gallery/bell.png') }}" alt="logolonceng" class="iconbell">
          <img src="{{ url('gallery/userfoto.png') }}" alt="logokananpojok" class="logouser">

        </div>
      </div>

      <div class="profile-section">
        <div class="profile-photo">
          <img src="{{ url('gallery/userfoto.png') }}" alt="Profile Photo">
        </div>
        <div class="details">
          <a id="dynamicLink" href="#" target="_blank" class="edit-button">Edit</a>
          <label>Full Name</label>
          <input type="text" placeholder="Hesel Aries Pratama">
          
          <label>Email</label>
          <input type="email"placeholder="Hexa@bussiness.co">

          <label>Age</label>
          <input type="text" placeholder="700 tahun">

          <label>Gender</label>
          <select>
            <option>Male</option>
            <option>Female</option>
          </select>

          <label>Country</label>
          <select>
            <option>Indonesia</option>
          </select>
        </div>
        <br>
        <a id="dynamicLink" href="#" target="_blank" class="btnmobile">Edit</a>
      </div>

      <div class="history-section">
        <div class="task-history">
          <h2>Completed Task History</h2>
          <table>
            <thead>
              <tr>
                <th>Platform</th>
                <th><img src="{{ url('gallery/heart.png') }}" alt="logolove"></th>
                <th><img src="{{ url('gallery/comment.png') }}" alt="logolove"></th>
                <th><img src="{{ url('gallery/share.png') }}" alt="logolove"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><img src="{{ url('gallery/logobrand.png') }}" alt="logoditask"></td>
                <td>100%</td>
                <td>100%</td>
                <td>100%</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="voucher-history">
          <h2>Voucher Redemption History</h2>
          <table>
            <thead>
              <tr>
                <th>Voucher</th>
                <th><img src="{{ url('gallery/coupon.png') }}" alt="logokupon"></th>
                <th><img src="{{ url('gallery/coupon.png') }}" alt="logokupon"></th>
                <th><img src="{{ url('gallery/coupon.png') }}" alt="logokupon"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>Status</th>
                <td class="status">Done</td>
                <td class="status">Done</td>
                <td class="status">Done</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="mobiledevice">
    <div class="profile-header">
    <h1>Profile</h1>
  </div>

  <div class="profile-container">
    <div class="profile-image">
      <img src="https://via.placeholder.com/100" alt="Profile Picture">
    </div>
    <div class="profile-info">
      <p><span>Name:</span> Muhammad Fauzi</p>
      <p><span>Gender:</span> Male</p>
      <p><span>Age:</span> 27 Years</p>
      <p><span>Email:</span> gfauzi543@gmail.com</p>
      <p><span>Phone:</span> +62 822 4493 8356</p>
      <p><span>Password:</span> ********</p>
      <button class="edit-button">Edit</button>
    </div>
    <div class="task-history">
      <h3>Completed Task History</h3>
      <table>
        <tr>
          <th>Platform</th>
          <th>Status</th>
        </tr>
        <tr>
          <td>PointPlay</td>
          <td>100%</td>
        </tr>
      </table>
    </div>
    <div class="voucher-history">
      <h3>Voucher Redemption History</h3>
      <table>
        <tr>
          <th>Voucher</th>
          <th>Status</th>
        </tr>
        <tr>
          <td>Voucher 1</td>
          <td class="done-status">Done</td>
        </tr>
        <tr>
          <td>Voucher 2</td>
          <td class="done-status">Done</td>
        </tr>
        <tr>
          <td>Voucher 3</td>
          <td class="done-status">Done</td>
        </tr>
      </table>
    </div>
  </div>
  </div>
</body>
</html>
