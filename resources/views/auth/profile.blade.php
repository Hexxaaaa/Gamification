<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <div class="container-fluid h-100">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-auto bg-light p-3 text-center">
        <ul class="list-unstyled">
          <li><a href="#"><img src="{{ url('gallery/logopoint.png') }}" alt="logo" class="img-fluid mb-3" style="width: 40px"></a></li>
          <li><a href="#"><img src="{{ url('gallery/menu.png') }}" alt="menu" class="img-fluid mb-3" style="width: 40px"></a></li>
          <li><a href="#"><img src="{{ url('gallery/list.png') }}" alt="listtugas" class="img-fluid mb-3" style="width: 40px"></a></li>
          <li><a href="#"><img src="{{ url('gallery/reward.png') }}" alt="reward" class="img-fluid mb-3" style="width: 40px"></a></li>
          <li><a href="#"><img src="{{ url('gallery/statistics.png') }}" alt="statistics" class="img-fluid mb-3" style="width: 40px"></a></li>
          <li><a href="#"><img src="{{ url('gallery/user.png') }}" alt="user" class="img-fluid mb-3" style="width: 40px"></a></li>
        </ul>
      </div>

      <!-- Main Content -->
      <div class="col">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
          <h1 class="h5">Welcome, Kelompok 1</h1>
          <div class="d-flex align-items-center">
            <input type="search" class="form-control me-2" placeholder="Search">
            <img src="{{ url('gallery/bell.png') }}" alt="logolonceng" class="img-fluid me-2" style="width: 20px;">
            <img src="{{ url('gallery/userfoto.png') }}" alt="logokananpojok" class="rounded-circle" style="width: 40px;">
          </div>
        </div>

        <!-- Profile Section -->
        <div class="card mt-3">
          <div class="card-body">
            <div class="row">
              <div class="col-auto">
                <img src="{{ url('gallery/userfoto.png') }}" alt="Profile Photo" class="rounded-circle" style="width: 100px;">
              </div>
              <div class="col">
                <form>
                  <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" placeholder="Hesel Aries Pratama">
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Hexa@bussiness.co">
                  </div>
                  <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="text" class="form-control" id="age" placeholder="700 tahun">
                  </div>
                  <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender">
                      <option>Male</option>
                      <option>Female</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select" id="country">
                      <option>Indonesia</option>
                    </select>
                  </div>
                  <button type="button" class="btn btn-primary">Edit</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- History Section -->
        <div class="row mt-4">
          <!-- Task History -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Completed Task History</h5>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Platform</th>
                      <th><img src="{{ url('gallery/heart.png') }}" alt="heart" class="img-fluid" style="width: 20px;"></th>
                      <th><img src="{{ url('gallery/comment.png') }}" alt="comment" class="img-fluid" style="width: 20px;"></th>
                      <th><img src="{{ url('gallery/share.png') }}" alt="share" class="img-fluid" style="width: 20px;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><img src="{{ url('gallery/logobrand.png') }}" alt="logobrand" class="img-fluid" style="width: 20px;"></td>
                      <td>100%</td>
                      <td>100%</td>
                      <td>100%</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Voucher History -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Voucher Redemption History</h5>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Voucher</th>
                      <th><img src="{{ url('gallery/coupon.png') }}" alt="coupon" class="img-fluid" style="width: 20px;"></th>
                      <th><img src="{{ url('gallery/coupon.png') }}" alt="coupon" class="img-fluid" style="width: 20px;"></th>
                      <th><img src="{{ url('gallery/coupon.png') }}" alt="coupon" class="img-fluid" style="width: 20px;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>Status</th>
                      <td class="text-success fw-bold">Done</td>
                      <td class="text-success fw-bold">Done</td>
                      <td class="text-success fw-bold">Done</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
