<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Query</title>
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
  <?php
    include './../../includes/main.php';
    include './../../api/db/connection.php';
    checkSession();
    $path = $GLOBALS['_path'];
  ?>
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
              <a href="#" onclick="window.history.back();"class="page-title-icon bg-gradient-primary text-white">
                <i class="mdi mdi-arrow-left-bold"></i>
              </a>
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span>Suggestion Details
              </h3>
            </div>
            <?php 
                $id = $_GET['id'];
                $Istmt = "SELECT q.sg_id,q.date,s.name,s.rollno,q.hostel,q.for_place,q.suggestion_title,q.sg_descrip,q.sg_photo_link FROM suggestions q left join students_info s ON q.reported_by=s.id  WHERE q.sg_id = ?;";
                $stmt = mysqli_prepare($db, $Istmt); mysqli_stmt_bind_param($stmt, "d",$id); mysqli_stmt_execute($stmt); $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_array($result);
                $for_place = ($row['for_place'] == 1) ? 'Hostel' : (($row['for_place'] == 2) ? 'Pathway' : (($row['for_place'] == 3) ? 'Student Center' : (($row['for_place'] == 4) ? 'Laundry' : 'Mini Canteen')));
            ?>
            <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">View Suggestion</h4>
                      <div class="form-group row" style="margin-bottom: 0rem;">
                        <label class="col-sm-2 col-form-label">Suggestion Id</label>
                        <span class="col-sm-9 col-form-label"><?php echo "SG-".$row['sg_id'] ?></span>
                      </div>
                      <div class="form-group row" style="margin-bottom: 0rem;">
                        <label class="col-sm-2 col-form-label">Reported By</label>
                        <span class="col-sm-9 col-form-label"><?php echo $row['name'].' - '.$row['rollno'] ?></span>
                      </div>
                      <div class="form-group row" style="margin-bottom: 0rem;">
                        <label class="col-sm-2 col-form-label">Hostel</label>
                        <span class="col-sm-9 col-form-label"><?php echo $row['hostel']?></span>
                      </div>
                      <div class="form-group row" style="margin-bottom: 0rem;">
                        <label class="col-sm-2 col-form-label">For & Title:</label>
                        <span class="col-sm-9 col-form-label"><?php echo $for_place.' - '.$row['suggestion_title'] ?></span>
                      </div>
                        <div class="form-group row" style="margin-bottom: 0rem;">
                            <label class="col-sm-2 col-form-label">Description:</label>
                            <span class="col-sm-9 col-form-label"><?php echo $row['sg_descrip'] ?></span>
                        </div>
                      <div class="form-group row" style="margin-bottom: 0rem;">
                        <label class="col-sm-2 col-form-label">Reported Date:</label>
                        <span class="col-sm-9 col-form-label"><?php echo $row['date']?></span>
                      </div>
                    
                      <div class="form-group row" style="margin-bottom: 0rem;">
                        <label class="col-sm-2 col-form-label">Photo:</label>
                       <div> <img src="<?php echo $row['sg_photo_link'] ?>" alt="No Photos Added" style="max-width:720px; max-height:480px;"> </div>
                      </div>
                    <br>
                    <?php
                     if($_SESSION['role']=='0'){
                      echo "<button onclick='DeleteSuggestion($row[sg_id])' type='button' style='box-shadow:none;' class='btn btn-gradient-danger btn-fw'>Delete Suggestion</button>";
                    }
                    else if(($row['status']==1))
                    echo "<button onclick='approve($row[query_id])' type='button' style='box-shadow:none;' class='btn btn-gradient-success btn-fw'>Approve Query</button>
                    <button onclick='decline($row[query_id])' type='button' style='box-shadow:none;' class='btn btn-gradient-danger btn-fw'>Decline Query</button>";
                    else
                    echo '';
                    ?>
                    <br>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
        function DeleteSuggestion(qid){
            var id = qid;
            var form_data = new FormData();
            form_data.append('q_id',id);
            $.ajax({
                url : './../../api/roomquery/delete.php',
                method : 'POST',
                dataType : 'json',
                cache : false,
                contentType : false,
                processData: false,
                data : form_data,
                success: function (result) {
                        console.log(result);
                        console.log(result.success);
                        if (result.success === true) {
                          window.history.back();
                        } else if (result.success === false) {
                             alert(result.message);
                        }
                },
                 error: function (err) {
                    console.log(err);
                }
            });
        }


        function approve(qid){
            var id = qid;
            var form_data = new FormData();
            form_data.append('q_id',id);
            $.ajax({
                url : './../../api/roomquery/approve.php',
                method : 'POST',
                dataType : 'json',
                cache : false,
                contentType : false,
                processData: false,
                data : form_data,
                success: function (result) {
                        console.log(result);
                        console.log(result.success);
                        if (result.success === true) {
                          window.history.back();
                        } else if (result.success === false) {
                             alert(result.message);
                        }
                },
                 error: function (err) {
                    console.log(err);
                }
            });
        }


        function decline(qid){
            var id = qid;
            var form_data = new FormData();
            form_data.append('q_id',id);
            $.ajax({
                url : './../../api/roomquery/decline.php',
                method : 'POST',
                dataType : 'json',
                cache : false,
                contentType : false,
                processData: false,
                data : form_data,
                success: function (result) {
                        console.log(result);
                        console.log(result.success);
                        if (result.success === true) {
                          window.history.back();
                        } else if (result.success === false) {
                             alert(result.message);
                        }
                },
                 error: function (err) {
                    console.log(err);
                }
            });
        }


        function close(qid){
            var id = qid;
            var form_data = new FormData();
            form_data.append('q_id',id);
            $.ajax({
                url : './../../api/roomquery/close.php',
                method : 'POST',
                dataType : 'json',
                cache : false,
                contentType : false,
                processData: false,
                data : form_data,
                success: function (result) {
                        console.log(result);
                        console.log(result.success);
                        if (result.success === true) {
                          window.history.back();
                        } else if (result.success === false) {
                             alert(result.message);
                        }
                },
                 error: function (err) {
                    console.log(err);
                }
            });
        }
</script>