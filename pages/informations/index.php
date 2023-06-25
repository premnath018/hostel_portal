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
    <title>Informations</title>
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
    <script src="./../../assets/vendors/js/vendor.bundle.base.js"></script> 
    <?php tb_script() ?>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php topbar() ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper" style="padding-left:0px; padding-right:0px ;">
        <!-- partial:partials/_sidebar.html -->
        <?php navbar() ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header"> 
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-format-list-bulleted"></i>
                </span> Informations
            </div>
            <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Contacts</h4>
                    <div class="tb-responsive">
                    <table class="table stripe hover row-border order-column" id="example" >
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Desigination</th>
                          <th>Hostel</th>
                          <th>Room No</th>
                          <th>Phone</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $Info = "SELECT * FROM informations";
                        $stmt = mysqli_prepare($db, $Info); mysqli_stmt_execute($stmt); $result = mysqli_stmt_get_result($stmt);
                        while ($row = mysqli_fetch_array($result)) {
                         
                            echo "<tr>";
                            echo "<td>$row[name]</td>
                            <td>$row[desigination]</td>
                            <td>$row[hostel]</td>
                            <td>$row[room_no]</td>
                            <td>$row[phone]</td>
                            </tr>";
                        }
                        ?>
                      </tbody>
                    </table>
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

<script>
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        // "order": [[ 6, "desc" ]],
        responsive: true,
        lengthChange: false,
    } );
} );

function view(id_no){
        let id = id_no;
        idh= id.toString(8);
        window.location.href = "./view.php?id=" + id;
    }

</script>
