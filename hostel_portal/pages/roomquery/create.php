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
    <title>Create Query</title>
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
                  <i class="mdi mdi-home"></i>
                </span> Create Room Query
              </h3>
            </div>
            <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Issue a Room Query</h4>
                    <br>
                    <form class="forms-sample">
                    <div class="row">
                    <div class="col-md-4">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-7 col-form-label"><?php echo $_SESSION['name']?></div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Hostel</label>
                        <div class="col-sm-9 col-form-label"><?php echo $_SESSION['hostel']?></div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Room No</label>
                        <div class="col-sm-8 col-form-label"><?php echo $_SESSION['room_no']?></div>
                      </div>
                    </div>
                  </div>
                  <?php 
                      $Sql = "SELECT * FROM master_category WHERE status = '1' ";
                      $checkResult = mysqli_query($db, $Sql);
                  ?>
                      <div class="form-group">
                        <label for="exampleSelectGender">Category</label>
                        <select id="category" class=" form-control" id="SelectCategory">
                   <?php
                      while ($row = $checkResult->fetch_assoc()){
                        if ($row['id'] != 2 && $row['id'] != 4 && $row['id'] != 5)
                       echo "<option value=$row[id]>$row[category_name]</option>";
                      }
                   ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Query Statement</label>
                        <textarea id="problem_statement" class="form-control" id="ProblemStatment" rows="4" required></textarea>
                      </div>
                      <div class="form-group">
                        <label>File upload ( *Optional )</label>
                        <input type="file" name="img[]" class="file-upload-default">
                        <div class="input-group col-xs-12">
                          <input type="file" id="query_upload"class="form-control file-upload-info" accept="image/x-png,image/jpg,image/jpeg" placeholder="Upload Image">
                        </div>
                      </div>
                      <button type="submit" onclick="CreateQuery()" class="btn btn-gradient-primary me-2">Submit</button>
                      <button type="button" onclick="back()" class="btn btn-light">Cancel</button>
                    </form>
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
        function CreateQuery(){
          event.preventDefault();
            var category = $('#category').val().trim();
            var prob_stmt = $('#problem_statement').val().trim();
            if (prob_stmt === '') {
                alert('Please provide the query statement.');
                return false; //prevent the form from submitting
            }
            var file_data= $('#query_upload').prop('files')[0];
            var form_data = new FormData();
            console.log('hello-');
            console.log(category,prob_stmt,file_data)
            form_data.append('file',file_data);
            form_data.append('p_category',category);
            form_data.append('p_statement',prob_stmt);
            $.ajax({
                url : './../../api/roomquery/create.php',
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
                          window.location.href='./';
                        } else if (result.success === false) {
                             alert(result.message);
                        }
                },
                 error: function (err) {
                    console.log(err);
                }
            });
        }
        function back(){
          window.history.back();
        }
</script>