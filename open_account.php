<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Account Opening</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("assets/images/bg form.jpg");
            /* background-color: #e9f0f7;*/
            background-size: cover; 
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-primary bg-primary">
    <div class="container">
      <h3 class="text-white text-center">EasyBank</h3>
      <div class="d-flex">
          <!-- <a href="#" class="d-block link-body-emphasis text-decoration-none"
            aria-expanded="false">
          </a> -->
        </div>
      </div>
    </div>
  </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h2>Bank Account Opening Form</h2>
                    </div>
                    <div class="card-body">
                        <form action="submit_account.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" required
                                    placeholder="Enter your full name">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    placeholder="Enter your email">
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
                                <input type="file" class="form-control" name="id_proof_front" accept="image/*" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Residential Address</label>
                                <textarea class="form-control" id="address" name="address" required
                                    placeholder="Enter your address" rows="4"></textarea>
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
    </div>

    <footer class="text-center py-3 bg-primary mt-4 text-white">
        &copy; <?php echo date('Y'); ?> EasyBank. All rights reserved.
    </footer>

    <!-- Bootstrap JS & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>