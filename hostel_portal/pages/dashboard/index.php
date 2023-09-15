<?php
    include './../../includes/main.php';
    include './../../api/db/connection.php';
    checkSession();
    $path = $GLOBALS['_path'];
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./../../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="./../../assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="./../../assets/images/favicon.ico" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php topbar() ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php navbar() ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-buffer"></i>
                </span> Dashboard
              </h3>
            </div>
            <div class="card">
              <div class="card-body">
                <h4 class="card-description">Welcome Back, <span class="card-title"><?php echo $_SESSION['name']?></span></h4>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Roll No</label>
                      <div class="col-sm-7 col-form-label"><?php echo $_SESSION['rollno']?></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Email id</label>
                      <div class="col-sm-9 col-form-label"><?php echo $_SESSION['email']?></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Year</label>
                      <div class="col-sm-8 col-form-label"><?php echo $_SESSION['year'].' Year'?></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Hostel</label>
                      <div class="col-sm-7 col-form-label"><?php echo $_SESSION['hostel']?></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Floor</label>
                      <div class="col-sm-9 col-form-label"><?php echo $_SESSION['floor'] === 'G' ? 'Ground Floor' : ($_SESSION['floor'] === '1' ? 'First Floor' :  ($_SESSION['floor'] === '2' ? 'Second Floor' : ($_SESSION['floor'] === '3' ? 'Third Floor' : '-'))); ?></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Room No</label>
                      <div class="col-sm-7 col-form-label"><?php echo $_SESSION['room_no']?></div>
                    </div>
                  </div>
                </div> 
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="./../../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Room Queries <i class="mdi mdi-home mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">15,0000</h2>
                    <button type="button" class="btn btn-gradient-danger btn-fw">Create Query</button>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="./../../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Suggestions <i class="mdi mdi-help-circle mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">45,6334</h2>
                    <button type="button" class="btn btn-gradient-info btn-fw">Create Suggestion</button>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="./../../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Daily Mess Rating <i class="mdi mdi-food-fork-drink mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">95,5741</h2>
                    <button type="button" class="btn btn-gradient-success btn-fw">Vote</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
              <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Designed By Premnath Mohankumar</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="./../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="./../../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="./../../assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="./../../assets/js/off-canvas.js"></script>
    <script src="./../../assets/js/hoverable-collapse.js"></script>
    <script src="./../../assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="./../../assets/js/dashboard.js"></script>
    <script src="./../../assets/js/todolist.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>