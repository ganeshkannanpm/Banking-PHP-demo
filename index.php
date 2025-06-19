<?php if (isset($_GET['logged_out'])): ?>
  <script>
    alert("You have been logged out.");
    // Remove the logged_out parameter without refreshing the page
    const url = new URL(window.location);
    url.searchParams.delete('logged_out');
    window.history.replaceState({}, document.title, url);
  </script>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Banking Application</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    .hover-card {
      transition: all 0.3s ease !important;
      background-color: #fff;
    }

    .hover-card:hover {
      transform: translateY(-6px);
      background: linear-gradient(135deg, #0d6efd, #6610f2);
      color: #fff;
      box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15);
    }

    .hover-card h5,
    .hover-card p {
      transition: color 0.3s ease;
    }

    .hover-card:hover h5,
    .hover-card:hover p {
      color: rgb(255, 255, 255) !important;
    }


    .hover-card:hover a {
      color: #0d6efd;
      background-color: #fff;
      border-color: #fff;
    }

    .hover-card:hover .display-5 {
      transform: scale(1.1);
      color: #0d6efd;
    }

    .nav-pills .nav-link {
      transition: all 0.3s ease;
      color: #0d6efd;
      border-radius: 50px;
    }

    .nav-pills .nav-link:hover {
      background: linear-gradient(135deg, #0d6efd, #6610f2);
      color: #fff;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    .nav-pills .nav-link.active {
      background: linear-gradient(135deg, #0d6efd, #6610f2);
      color: #fff;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
      transition: all 0.3s ease;
      background: linear-gradient(135deg, #0d6efd, #6610f2);
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #0d6efd, #6610f2);
      border-color: #6610f2;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      border-radius: 50px;

    }

    .image-container {
      position: relative;
      overflow: hidden;
    }

    .image-container img {
      width: 100%;
      display: block;
      transition: transform 0.4s ease;
    }

    /* Door panels */
    .door-left,
    .door-right {
      position: absolute;
      top: 0;
      width: 50%;
      height: 100%;
      background: linear-gradient(to right, rgba(13, 110, 253, 0.4), rgba(102, 16, 242, 0.4));
      /* semi-transparent */
      transition: transform 0.6s ease-in-out;
      z-index: 2;
      pointer-events: none;
      /* Allow hover through gradient */
    }

    /* Initial positions (off-screen) */
    .door-left {
      left: -50%;
      transform: translateX(0);
    }

    .door-right {
      right: -50%;
      transform: translateX(0);
    }

    /* On hover, slide doors to center */
    .image-container:hover .door-left {
      transform: translateX(100%);
    }

    .image-container:hover .door-right {
      transform: translateX(-100%);
    }

    /* Optional image zoom */
    .image-container:hover img {
      transform: scale(1.05);
    }
  </style>
</head>

<body>

  <!-- Header -->

  <header>
    <div>
      <header class="p-3 text-bg-dark fixed-top">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none header-nav">
              <h2>EasyBank</h2>
              <!-- <img src="assets/images/Icon.PNG" alt=""  width="130px" height="50px"> -->
            </a>
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 ms-5 justify-content-center mb-md-0">
              <li><a href="#" class="nav-link px-2 text-white header-nav">Home</a></li>
              <li><a href="#" class="nav-link px-2 text-white header-nav">About</a></li>
              <li><a href="#" class="nav-link px-2 text-white header-nav">Services</a></li>
              <li><a href="#" class="nav-link px-2 text-white header-nav">Accounts</a></li>
              <li><a href="#" class="nav-link px-2 text-white header-nav">Contact</a></li>
            </ul>
            <form class="d-flex ms-lg-3 my-2 my-lg-0" role="search">
              <input class="form-control me-2" type="search" placeholder="Search articles..." aria-label="Search">
              <button class="btn btn-primary" type="submit">Search</button>
            </form>
            <div class="text-end">
              <button type="button" class="btn btn-primary ms-2 me-2" data-bs-toggle="modal"
                data-bs-target="#loginModal">Login</button>
            </div>
          </div>
        </div>
      </header>
    </div>
  </header>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-3 shadow">
        <div style="background: linear-gradient(135deg, #0d6efd, #6610f2);" class="modal-header text-center bg-primary">
          <h5 class="modal-title text-white" id="loginModalLabel">User login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="login-process.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label text-dark">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Email address" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label text-dark">Password</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            </div>
            <button type="submit" name="btn-login" class="btn btn-primary w-100">Login</button>
          </form>
          <div class="mt-3 text-center">
            <p class="mb-0">Don't have an account? <a href="#registerModal" data-bs-toggle="modal"
                data-bs-target="#registerModal" class="text-primary">Create your account</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Modal -->

  <!-- Register Modal -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-3 shadow">
        <div style="background: linear-gradient(135deg, #0d6efd, #6610f2);" class="modal-header text-center bg-primary">
          <h5 class="modal-title text-white text-center" id="registerModalLabel">Register your account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="register-process.php" method="POST">
            <div class="mb-3">
              <label for="fullname" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="mb-3">
              <label for="registerEmail" class="form-label text-dark">Email</label>
              <input type="email" name="email" class="form-control" id="registerEmail" placeholder="Email address">
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
              <label for="registerPassword" class="form-label text-dark">Password</label>
              <input type="password" name="password" class="form-control" id="registerPassword" placeholder="Password">
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label text-dark">Confirm Password</label>
              <input type="password" name="confirm_password" class="form-control" id="confirmPassword"
                placeholder="Confirm your password">
            </div>
            <button type="submit" name="btn-register" class="btn btn-primary w-100">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Register Modal -->

  <!-- Open Account Modal -->
  <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div style="background: linear-gradient(135deg, #0d6efd, #6610f2);" class="modal-header bg-primary text-white">
          <h5 class="modal-title text-center" id="accountModalLabel">Account Opening Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Your form goes here -->
          <form action="submit_account.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="fullname" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="fullname" name="fullname" required
                placeholder="Enter your full name">
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
            </div>

            <div class="mb-3">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phone" name="phone" required
                placeholder="Enter your phone number">
            </div>

            <!-- DOB -->
            <div class="mb-3">
              <label for="dob" class="form-label">Date of Birth</label>
              <input type="date" class="form-control" id="dob" name="dob" required>
            </div>

            <!-- Gender -->
            <div class="mb-3">
              <label class="form-label">Gender</label>
              <select class="form-select" name="gender" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <!-- PAN -->
            <div class="mb-3">
              <label for="pan_number" class="form-label">PAN Number</label>
              <input type="text" class="form-control" id="pan_number" name="pan_number" required>
            </div>

            <!-- Photo Upload -->
            <div class="mb-3">
              <label class="form-label">Profile Photo</label>
              <input type="file" class="form-control" name="photo" accept="image/*" required>
            </div>

            <!-- ID Proof -->
            <div class="mb-3">
              <label class="form-label">ID Proof</label>
              <input type="file" class="form-control" name="id_proof" accept="image/*" required>
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">Residential Address</label>
              <textarea class="form-control" id="address" name="address" required placeholder="Enter your address"
                rows="4"></textarea>
            </div>

            <div class="mb-3">
              <label for="account_type" class="form-label">Account Type</label>
              <select class="form-select" id="account_type" name="account_type" required>
                <option value="savings">Savings Account</option>
                <option value="current">Current Account</option>
                <option value="joint">Joint Account</option>
              </select>
            </div>

            <!-- Signature -->
            <div class="mb-3">
              <label class="form-label">Signature</label>
              <input type="file" class="form-control" name="signature" accept="image/*" required>
            </div>



            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required
                placeholder="Create a password">
            </div>

            <button type="submit" name="btn-openac" class="btn btn-primary w-100">Open Account</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Open Account Modal -->

  <!-- Slideshow -->
  <div class="position-relative overflow-hidden text-center hero-section">

    <!-- Slider Section -->
    <div class="slider">
      <img src="assets/images/banner1.jpg" class="slide active">
      <img src="assets/images/banner2.jpg" class="slide">
      <img src="assets/images/banner3.jpg" class="slide">
    </div>

    <!-- Overlay Content -->
    <div class="overlay">
      <h1 class="display-3 fw-bold">Your trusted partner</h1>
      <h3 class="fw-normal mb-3">Manage your money with confidence — anytime, anywhere.</h3>
      <a class="btn btn-primary" href="#">Learn more</a>
    </div>

  </div>
  <!-- Slideshow -->

  <!-- About Us -->
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6" data-aos="fade-right" data-aos-duration="3000">
        <img src="assets/images/about.jpg" alt="" width="100%" height="100%">
      </div>

      <div class="col-lg-6 col-md-8 mt-5 mx-auto" data-aos="fade-left" data-aos-duration="3000">
        <h1 class="fw-bold">About EasyBank</h1>
        <p class="lead text-dark">At EasyBank, we believe in empowering your financial future.
          With decades of experience and a commitment to innovation,we deliver personalized banking services designed to
          meet your needs.
          Your success is our mission.We understand that every customer is unique, which is why we offer flexible,
          secure,
          and easy-to-use banking solutions. From savings accounts and loans to mobile banking and investment advice,
          our comprehensive range of services is built to support you at every stage of life.</p>
        <p>
          <a href="#" class="btn btn-primary my-2">Learn More</a>
          <!-- <a href="#" class="btn btn-secondary my-2">Secondary action</a> -->
        </p>
      </div>
    </div>
  </section>
  <!-- About Us -->

  <!-- Counter -->
  <section class="py-5 bg-light">
    <div class="container text-center" data-aos="fade-down" data-aos-duration="3000">
      <h2 class="mb-4 fs-2 fw-bold">Our Achievements</h2>
      <p class="text-muted fs-5 mb-5">Trusted nationwide with a growing impact.</p>

      <div class="row g-4">
        <div class="col-6 col-md-3">
          <i class="bi bi-people-fill fs-1 text-primary mb-2"></i>
          <h3 class="fw-bold text-primary">
            <span class="counter">10000</span>+
          </h3>
          <p>Happy Customers</p>
        </div>
        <div class="col-6 col-md-3">
          <i class="bi bi-building fs-1 text-primary mb-2"></i>
          <h3 class="fw-bold text-primary">
            <span class="counter">120</span>
          </h3>
          <p>Branches</p>
        </div>
        <div class="col-6 col-md-3">
          <i class="bi bi-arrow-left-right fs-1 text-primary mb-2"></i>
          <h3 class="fw-bold text-primary">
            <span class="counter">5000</span>+
          </h3>
          <p>Transactions / Day</p>
        </div>
        <div class="col-6 col-md-3">
          <i class="bi bi-award-fill fs-1 text-primary mb-2"></i>
          <h3 class="fw-bold text-primary">
            <span class="counter">25</span>
          </h3>
          <p>Years of Service</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Counter -->

  <!-- Why Choose -->
  <section class="bg-light py-5">
    <div class="container text-center" data-aos="fade-up" data-aos-duration="3000">
      <h2 class="mb-3 fw-bold">Why Choose EasyBank?</h2>
      <p class="text-dark fs-4 mb-5">Explore the key features that make EasyBank your trusted financial partner.</p>

      <!-- Feature Highlights -->
      <div class="row g-4 mb-5">
        <div class="col-md-3">
          <div class="p-4 bg-white shadow-lg rounded hover-card">
            <div class="display-5 mb-3">💡</div>
            <h5 class="fw-semibold">Smart Banking</h5>
            <p class="text-muted small">Innovative tools designed for modern banking convenience.</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="p-4 bg-white shadow-lg rounded hover-card">
            <div class="display-5 mb-3">🔒</div>
            <h5 class="fw-semibold">Secure & Reliable</h5>
            <p class="text-muted small">Advanced security to protect your finances and data.</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="p-4 bg-white shadow-lg rounded hover-card">
            <div class="display-5 mb-3">🌍</div>
            <h5 class="fw-semibold">Global Access</h5>
            <p class="text-muted small">Manage your money anywhere, anytime on any device.</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="p-4 bg-white shadow-lg rounded hover-card">
            <div class="display-5 mb-3">💬</div>
            <h5 class="fw-semibold">24/7 Support</h5>
            <p class="text-muted small">Expert assistance whenever you need it, day or night.</p>
          </div>
        </div>
      </div>


      <!-- Call to Action Cards -->
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-lg rounded hover-card">
            <div class="card-body">
              <h5 class="card-title text-primary">📱 Download the App</h5>
              <p class="card-text">Experience banking at your fingertips. Get our mobile app today.</p>
              <a href="#" class="btn btn-outline-primary btn-sm">Get the App</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-lg rounded hover-card">
            <div class="card-body">
              <h5 class="card-title text-primary">🧾 Open an Account</h5>
              <p class="card-text">Join EasyBank in minutes. Start your financial journey today.</p>
              <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#accountModal">Open Now</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-lg rounded hover-card">
            <div class="card-body">
              <h5 class="card-title text-primary">🏦 Visit a Branch</h5>
              <p class="card-text">Find the nearest branch and get personalized assistance.</p>
              <a href="#" class="btn btn-outline-primary btn-sm">Find a Branch</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Why Choose -->

  <!-- Services Section -->
  <div class="container px-4 py-5" id="services" data-aos="fade-up" data-aos-duration="3000">
    <h2 class="pb-2 fw-bold text-center border-bottom">Our Services</h2>

    <!-- Tabs -->
    <ul class="nav nav-pills mb-3 justify-content-center mt-4" id="services-tabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button"
          role="tab">All</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link " id="accounts-tab" data-bs-toggle="pill" data-bs-target="#accounts" type="button"
          role="tab">Accounts</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="loans-tab" data-bs-toggle="pill" data-bs-target="#loans" type="button"
          role="tab">Loans</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="digital-tab" data-bs-toggle="pill" data-bs-target="#digital" type="button"
          role="tab">Digital Banking</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="security-tab" data-bs-toggle="pill" data-bs-target="#security" type="button"
          role="tab">Security & Insurance</button>
      </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="services-tabs-content">

      <div class="tab-pane fade show active" id="all" role="tabpanel">
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4" id="all-container"></div>
      </div>

      <!-- Accounts -->
      <div class="tab-pane fade" id="accounts" role="tabpanel">
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
          <div class="col">
            <div class="card h-100 shadow card-hover ">
              <div class="image-container">
                <img src="assets/images/service2.jpg" class="card-img-top zoom-img" alt="Internet Banking">
                <!-- <div class="door-left"></div> -->
                <!-- <div class="door-right"></div> -->
              </div>
              <!-- <div class="image-container">
                <img src="assets/images/service2.jpg" class="card-img-top" alt="...">
                <div class="gradient-door"></div>
              </div> -->

              <div class="card-body">
                <h5 class="card-title">Savings Account</h5>
                <p class="card-text">Earn interest and save securely with 24/7 access.</p>
              </div>
            </div>

          </div>
          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/currentacc.jpg" class="card-img-top zoom-img" alt="Internet Banking">
              </div>
              <div class="card-body">
                <h5 class="card-title">Current Account</h5>
                <p class="card-text">Business-friendly features for high transaction volumes.</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/fixed.jpg" class="card-img-top zoom-img" alt="Internet Banking">
              </div>
              <div class="card-body">
                <h5 class="card-title">Fixed Deposits</h5>
                <p class="card-text">Higher interest for fixed-term deposits.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Loans -->
      <div class="tab-pane fade" id="loans" role="tabpanel">
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/personal.jpg" class="card-img-top zoom-img" alt="Internet Banking">
              </div>
              <div class="card-body">
                <h5 class="card-title">Personal Loan</h5>
                <p class="card-text">Quick approvals and competitive interest rates.</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/homeloan.jpg" class="card-img-top zoom-img" alt="Internet Banking">
              </div>
              <div class="card-body">
                <h5 class="card-title">Home Loan</h5>
                <p class="card-text">Low EMIs and flexible tenures to buy your dream home.</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/carloan.jpg" class="card-img-top zoom-img" alt="Internet Banking">
              </div>
              <div class="card-body">
                <h5 class="card-title">Car Loan</h5>
                <p class="card-text">Drive home your dream car.</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/education.jpg" class="card-img-top zoom-img" alt="Internet Banking">
              </div>
              <div class="card-body">
                <h5 class="card-title">Education Loans</h5>
                <p class="card-text">Secure your child’s future.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Digital Banking -->
      <div class="tab-pane fade" id="digital" role="tabpanel">
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">

          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/internet.jpg" class="card-img-top zoom-img" alt="Internet Banking">
              </div>
              <div class="card-body">
                <h5 class="card-title">Internet Banking</h5>
                <p class="card-text">Bank anytime, anywhere with our secure platform.</p>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/mobile.jpg" class="card-img-top zoom-img" alt="Mobile App">
              </div>
              <div class="card-body">
                <h5 class="card-title">Mobile App</h5>
                <p class="card-text">Manage your finances on-the-go with our mobile app.</p>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/upipay.jpg" class="card-img-top zoom-img" alt="Internet Banking">
              </div>
              <div class="card-body">
                <h5 class="card-title">UPI / QR Payments</h5>
                <p class="card-text">Instant transfers & merchant payments.</p>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/fund.jpg" class="card-img-top zoom-img" alt="Mobile App">
              </div>
              <div class="card-body">
                <h5 class="card-title">Fund Transfer (NEFT/RTGS/IMPS)</h5>
                <p class="card-text">Multiple transfer options, 24x7.</p>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!-- Digital Banking -->

      <!-- Security & Insurance -->
      <div class="tab-pane fade" id="security" role="tabpanel">
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">

          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/life.jpg" class="card-img-top zoom-img" alt="Insurance Services">
              </div>
              <div class="card-body">
                <h5 class="card-title">Insurance Services</h5>
                <p class="card-text">Life, health, and travel insurance.</p>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card h-100 shadow card-hover">
              <div class="image-container">
                <img src="assets/images/safelock.jpg" class="card-img-top zoom-img" alt="Safe Deposit Lockers">
              </div>
              <div class="card-body">
                <h5 class="card-title">Safe Deposit Lockers</h5>
                <p class="card-text">Store valuables with top-tier security</p>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!-- Security & Insurance -->

    </div>
  </div>
  <!-- Services Section -->

  <!-- Testimonial -->
  <section id="testimonials" class="bg-light py-5">
    <div class="container">
      <h2 class="text-center mb-5">What Our Clients Say</h2>

      <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000"
        data-aos="zoom-in" data-aos-duration="3000">

        <!-- Indicators -->
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="3"
            aria-label="Slide 4"></button>
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="4"
            aria-label="Slide 5"></button>
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="5"
            aria-label="Slide 6"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner text-center">

          <div class="carousel-item active">
            <img src="assets/images/John Doe.jpg" width="150px" height="150px" class="rounded-circle mb-3"
              alt="John Doe">
            <p class="px-3">"The services provided by this bank are exceptional. Their mobile app is easy to use, and
              the customer service is always helpful."</p>
            <h6><strong>John Doe</strong></h6>
            <small class="text-muted">Small Business Owner</small>
          </div>

          <div class="carousel-item">
            <img src="assets/images/Sarah Smith.jpg" width="150px" height="150px" class="rounded-circle mb-3"
              alt="Sarah Smith">
            <p class="px-3">"I’ve been using this bank for years, and I can’t imagine going anywhere else. The ease of
              banking is unparalleled!"</p>
            <h6><strong>Sarah Smith</strong></h6>
            <small class="text-muted">Freelance Designer</small>
          </div>

          <div class="carousel-item">
            <img src="assets/images/James Albert.jpg" width="150px" height="150px" class="rounded-circle mb-3"
              alt="James Lee">
            <p class="px-3">"Their customer care is responsive and professional. I've had great experiences managing my
              finances here."</p>
            <h6><strong>James Albert</strong></h6>
            <small class="text-muted">Entrepreneur</small>
          </div>

          <div class="carousel-item">
            <img src="assets/images/Anita Kapoor.jpg" width="150px" height="150px" class="rounded-circle mb-3"
              alt="Anita Kapoor">
            <p class="px-3">"Great bank for digital users. I never need to visit a branch, everything is smooth and
              online."</p>
            <h6><strong>Anita Kapoor</strong></h6>
            <small class="text-muted">Software Engineer</small>
          </div>

          <div class="carousel-item">
            <img src="assets/images/Carlos Diaz.jpg" width="150px" height="150px" class="rounded-circle mb-3"
              alt="Carlos Diaz">
            <p class="px-3">"Excellent rates and very secure online banking. I feel confident storing my savings here."
            </p>
            <h6><strong>Carlos Diaz</strong></h6>
            <small class="text-muted">Financial Analyst</small>
          </div>

          <div class="carousel-item">
            <img src="assets/images/Lina Park.jpg" width="150px" height="150px" class="rounded-circle mb-3"
              alt="Lina Park">
            <p class="px-3">"Their support team helped me set up my business account quickly. Everything was seamless!"
            </p>
            <h6><strong>Lina Park</strong></h6>
            <small class="text-muted">Startup Founder</small>
          </div>

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev text-primary" type="button" data-bs-target="#testimonialCarousel"
          data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next text-primary" type="button" data-bs-target="#testimonialCarousel"
          data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>

      </div>
    </div>
  </section>
  <!-- Testimonial -->



  <main>

    <div class="b-example-divider"></div>
    <div class="b-example-divider"></div>
    <div class="b-example-divider"></div>
    <div class="b-example-divider"></div>
    <div class="b-example-divider"></div>

    <!-- CONTACT SECTION -->
    <div class="contact-section">
      <div class="overlay"></div>
      <div class="container col-xl-10 col-xxl-8 px-4 py-5 ">
        <div class="row align-items-center g-lg-5 py-5" data-aos="fade-down" data-aos-duration="3000">
          <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 text-white mb-3">Contact Us</h1>
            <p class="col-lg-10 fs-4">
              We are here to assist you! Whether you have a question about your account,
              need help with a transaction, or want to provide feedback, our team is ready to help.
            </p>
            <ul class="list-unstyled mt-4">
              <li><strong>Phone:</strong> 1-800-123-4567</li>
              <li><strong>Email:</strong> <a style="text-decoration: none;" class="text-white"
                  href="#">example@easybank.com</a></li>
              <li><strong>Address:</strong> EasyBank Street, City, Country</li>
              <li><strong>Support Hours:</strong> Mon-Fri 10:00 AM - 5:00 PM</li>
            </ul>
          </div>
          <div class="col-md-10 mx-auto col-lg-5">
            <form action="submit-contact.php" method="POST" class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
              <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="floatingName" placeholder="Your Name" required>
                <label for="floatingName">Name</label>
              </div>
              <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="name@example.com"
                  required>
                <label for="floatingEmail">Email address</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" name="subject" class="form-control" id="floatingSubject" placeholder="Subject"
                  required>
                <label for="floatingSubject">Subject</label>
              </div>
              <div class="form-floating mb-3">
                <textarea class="form-control" name="message" placeholder="Leave your message here" id="floatingMessage"
                  style="height: 150px;" required></textarea>
                <label for="floatingMessage">Message</label>
              </div>
              <button name="btn-contact" class="w-100 btn btn-lg btn-primary" type="submit">Send Message</button>
            </form>



          </div>
        </div>
      </div>
    </div>
    <!-- CONTACT SECTION -->

    <div class="b-example-divider mb-0"></div>
  </main>

  <!-- Footer -->
  <footer class="py-5 text-bg-dark">
    <div class="container" data-aos="fade-up" data-aos-duration="3000">
      <div class="row">

        <!-- Section Links -->
        <div class="col-6 col-md-3 mb-3">
          <h5>Section</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white footer-link">Home</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white footer-link">About</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white footer-link">Services</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white footer-link">Accounts</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white footer-link">Contact</a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div class="col-6 col-md-3 mb-3">
          <h5>Contact</h5>
          <ul class="list-unstyled mt-4">
            <li><i class="fas fa-phone me-2 text-white"></i> <a href="tel:18001234567"
                class="footer-link">1-800-123-4567</a></li>
            <li><i class="fas fa-envelope me-2 text-white"></i> <a href="mailto:example@easybank.com"
                class="footer-link">example@easybank.com</a></li>

            <li><i class="fas fa-map-marker-alt me-2 text-white"></i> <a href="" class="footer-link">EasyBank Street,
                City,
                Country</a></li>
            <li><i class="fas fa-clock me-2 text-white"></i> Mon-Fri 10:00 AM - 5:00PM</li>
            </li>
          </ul>
        </div>


        <!-- Newsletter -->
        <div class="col-12 col-md-5 mb-3">
          <form>
            <h5>Subscribe to our newsletter</h5>
            <p>Monthly digest of what's new and exciting from us.</p>
            <div class="d-flex flex-column flex-sm-row w-100 gap-2">
              <label for="newsletter1" class="visually-hidden">Email address</label>
              <input id="newsletter1" type="email" class="form-control" placeholder="Email address">
              <button class="btn btn-primary" type="submit">Subscribe</button>
            </div>
          </form>
        </div>

      </div>

      <!-- Footer Bottom -->
      <div class="d-flex flex-column flex-sm-row justify-content-between py-4 mt-5 border-top">
        <a href="#" class="text-white text-decoration-none header-nav">
          <h2>EasyBank</h2>
        </a>
        <p>&copy; <span id="year"></span> EasyBank, Inc. All rights reserved.</p>
        <ul class="list-unstyled d-flex">
          <li class="ms-3"><a class="text-white footer-icon" href="#"><i class="bi bi-whatsapp"></i></a></li>
          <li class="ms-3"><a class="text-white footer-icon" href="#"><i class="bi bi-instagram"></i></a></li>
          <li class="ms-3"><a class="text-white footer-icon" href="#"><i class="bi bi-facebook"></i></a></li>
          <li class="ms-3"><a class="text-white footer-icon" href="#"><i class="bi bi-twitter"></i></a></li>
        </ul>
      </div>
    </div>

    <!-- Back to Top Button -->
    <button id="backToTop" class="btn btn-sm btn-primary position-fixed bottom-0 end-0 m-4 rounded-circle shadow-lg d-none"
      style="z-index: 1050;" title="Back to top">
      ↑
    </button>

    <!-- Year auto-update -->
    <script>
      document.getElementById('year').textContent = new Date().getFullYear();

      // Show/hide back to top button
      const backToTop = document.getElementById('backToTop');
      window.addEventListener('scroll', () => {
        backToTop.classList.toggle('d-none', window.scrollY < 300);
      });

      // Scroll to top on click
      backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    </script>

  </footer>
  <!-- Footer -->

  <!-- jQuery (Required for Counter-Up) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Waypoints (required for scroll detection) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
  <!-- Counter-Up -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>

  <script>
    $(document).ready(function () {
      $('.counter').counterUp({
        delay: 10,
        time: 1000
      });
    });
  </script>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

  <!-- <script>
    window.addEventListener('scroll', function () {
      if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        document.querySelector('#myElement').setAttribute('data-aos', 'fade-up');
        AOS.refresh(); // refresh AOS to apply it
      }
    });

  </script> -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>

  <script src="assets/js/script.js"></script>
  <script src="assets/js/slider.js"></script>


</body>

</html>