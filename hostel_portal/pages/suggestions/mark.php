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
                </span> Mark Suggestion
              </h3>
            </div>
            <?php
            $id = base64_decode($_GET['id']);
            $Istmt = "SELECT q.sg_id,q.date,s.name,s.rollno,q.hostel,q.for_place,q.suggestion_title,q.sg_descrip,q.sg_photo_link FROM suggestions q left join students_info s ON q.reported_by=s.id  WHERE q.sg_id = ?;";
            $stmt = mysqli_prepare($db, $Istmt); mysqli_stmt_bind_param($stmt, "d",$id); mysqli_stmt_execute($stmt); $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $for_place = ($row['for_place'] == 1) ? 'Hostel' : (($row['for_place'] == 2) ? 'Pathway' : (($row['for_place'] == 3) ? 'Student Center' : (($row['for_place'] == 4) ? 'Laundry' : 'Mini Canteen')));
            echo "<p id='for_place' style='display:none'>$row[for_place]</p>";
            $value = $row;
            ?>
            <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Mark Suggestion</h4>
                    <br>
                    <form class="forms-sample">
                    <div class="row">
                    <div class="col-md-4">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">SG ID:</label>
                        <div class="col-sm-5 col-form-label"><?php echo 'SG-'.$row['sg_id']?></div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group row">
                        <label class="col-sm-4   col-form-label">Reported By</label>
                        <div class="col-sm-5 col-form-label"><?php echo $row['rollno']?></div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">For</label>
                        <div class="col-sm-5 col-form-label"><?php echo $for_place ?></div>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Title:</label>
                        <div class="col-sm-9 col-form-label"><?php echo $row['suggestion_title']?></div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group row">
                        <label class="col-sm-4   col-form-label">Date</label>
                        <div class="col-sm-5 col-form-label"><?php echo $row['date']?></div>
                      </div>
                    </div>
                </div>
                <?php 
                      $Sql = "SELECT * FROM master_category WHERE status = '1' ";
                      $checkResult = mysqli_query($db, $Sql);
                  ?>
                      <div class="form-group">
                        <label for="exampleSelectGender">Assign To</label>
                        <select id="category" class=" form-control" id="SelectCategory" placeholder="Select Problem Type">
                   <?php
                      while ($row = $checkResult->fetch_assoc()){
                       echo "<option value='$row[id]'>$row[category_name]</option>";
                      }
                   ?>
                      </select>
                    </div>
                    <div class="form-group">
                    <label >Task Title</label>
                        <input type="text" class="form-control" id="tasktitle" placeholder="Task Title" required>
                    </div>

                      <div class="form-group">
                        <label>Task Description</label>
                        <textarea id="taskdescrip" class="form-control" id="description" rows="4" required></textarea>
                      </div>
                      <button onclick="MarkSuggestions()" class="btn btn-gradient-primary me-2">Submit</button>
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
        function MarkSuggestions(){
          event.preventDefault();
          var sg_id=<?php echo $value['sg_id']  ;?>;
          var hostel= '<?php echo $value['hostel']  ;?>';
          var date='<?php echo $value['date']  ;?>';
          var for_place='<?php echo $value['for_place']  ;?>';
          var suggestion_title='<?php echo $value['suggestion_title']  ;?>';
          var task_title= $('#tasktitle').val().trim();
          var task_descrip= $('#taskdescrip').val().trim();
          var category= $('#category').val().trim();
          if (task_title == '' || task_descrip == ''){
              alert ("Fill The Form");
              return false;
            }
            // Create a new FormData object
            var form_data = new FormData();

            // Append variables to the FormData object
            form_data.append('sg_id', sg_id);
            form_data.append('hostel', hostel);
            form_data.append('date', date);
            form_data.append('for_place', for_place);
            form_data.append('suggestion_title', suggestion_title);
            form_data.append('task_title', task_title);
            form_data.append('task_descrip', task_descrip);
            form_data.append('category', category);
            $.ajax({
                url : './../../api/suggestions/mark.php',
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