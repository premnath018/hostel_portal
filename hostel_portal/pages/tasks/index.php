<?php
    include './../../includes/main.php';
    include './../../api/db/connection.php';
    checkSession();
    $path = $GLOBALS['_path'];
    CheckRole("3-4",$_SESSION['role'])
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tasks</title>
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
                  <i class="mdi mdi-home"></i>
                </span> Task List
              </h3>
            </div>
            <?php
            $Mstmt = "('0','1','2')";
            if (isset($_GET['sorted'])){
              $sorted=$_GET['sorted'];
              $Mstmt = $sorted=='Initiated'?"('1')":($sorted=='Completed'?"('2')":"('0','1','2')");                      
            }
            $var_id = "Query Id";
            $var_room_for = "Room No";
            $var_prb_title = "Problem Statement";
            if (isset($_GET['category'])){
              $category=$_GET['category']; 
                if ($category == "suggestion-tasks"){
                  $var_id = "Sg Id";
                  $var_room_for = "For";
                  $var_prb_title = "Title"; 
              }
            }   
            ?>
            <div class="card">
                  <div class="card-body">
                    <div class="page-header">
                    <h4 class="page-title">Task List</h4>
                    <nav aria-label="breadcrumb" style="display:inline-flex">
                    <select id="category1" class="form-control" style="display: inline;">
                      <option disabled selected>Select Category</option>
                      <option value="room-tasks">Room Tasks</option>
                      <option value="suggestion-tasks">Suggestion Tasks</option>                       
                    </select>
                    <select id="category2" class="form-control" style="display: inline;">
                    <option disabled selected>Select Status</option>
                    <option>All</option>
                    <?php 
                    if ($_SESSION['role']=='3'){
                     echo '<option>Queued</option>';
                      } ?>
                      <option>Initiated</option>
                      <option>Completed</option>
                    </select>
                  </nav>
                    </div>
                    <div class="tb-responsive">
                    <table class="table stripe hover row-border order-column" id="example" >
                      <thead>
                        <tr>
                          <th><?php echo $var_id ?></th>
                          <th>Reported By</th>
                          <th>Hostel</th>
                          <th><?php echo $var_room_for ?></th>
                          <th>Category</th>
                          <th><?php echo $var_prb_title  ?></th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (isset($_GET['category'])){
                          $category=$_GET['category']; 
                            if ($category == "suggestion-tasks"){
                            $Istmt = "SELECT q.sg_id, q.reported_by, q.hostel, q.for_place, q.category, q.task_title, q.task_descrip, q.date, q.status, q.task_status 
                            FROM suggestions_tasks q 
                            RIGHT JOIN students_info s ON q.reported_by = s.id 
                            WHERE q.task_status IN ".$Mstmt."   
                            AND q.category = " . $_SESSION['category'] . " 
                            ORDER BY q.sg_id ASC;";
                            if ($_SESSION['role']=='3'){
                              $Istmt = "SELECT q.sg_id, q.reported_by, q.hostel, q.for_place, q.category, q.task_title, q.task_descrip, q.date, q.status, q.task_status FROM suggestions_tasks q LEFT JOIN students_info s ON q.reported_by = s.id WHERE q.status = '0' AND q.task_status IS NULL ORDER BY q.sg_id DESC;";}
                              $stmt = mysqli_prepare($db, $Istmt); 
                              mysqli_stmt_execute($stmt); 
                              $result = mysqli_stmt_get_result($stmt);                       
                              while ($row = mysqli_fetch_array($result)) {     
                              $for_place = ($row['for_place'] == 1) ? 'Hostel' : (($row['for_place'] == 2) ? 'Pathway' : (($row['for_place'] == 3) ? 'Student Center' : (($row['for_place'] == 4) ? 'Laundry' : 'Mini Canteen')));                     
                              $action = $row['task_status'] == null ? "<button onclick='suggestion_generate({$row['sg_id']})' type='button' class='btn-m btn-gradient-success btn-fw' style='box-shadow:none; margin-left:3%'>Generate Task Id</button>" :
                              ($row['task_status'] == 0 ? "<button onclick='suggestion_initiate({$row['sg_id']})' type='button' class='btn-m btn-gradient-info btn-fw' style='box-shadow:none; margin-left:3%'><strong>Initiate Task</strong></button>" :
                              ($row['task_status'] == 1 ? "<button onclick='suggestion_complete({$row['sg_id']})' type='button' class='btn-m btn-gradient-warning btn-fw' style='box-shadow:none; margin-left:3%'><strong>Complete Task</strong></button>" :
                              "<button type='button' class='btn-m btn-gradient-success btn-fw' style='box-shadow:none; margin-left:3%'><strong>Completed</strong></button>"));
                              if($_SESSION['role']!=0){
                              $category = ($row['category'] == 1) ? 'Electrical' :  (($row['category'] == 2) ? 'Plumbing' : (
                                  (($row['category'] == 3) ? 'Carpentry' : (
                                  (($row['category'] == 4) ? 'Cleaning' : (
                                  (($row['category'] == 5) ? 'Civil Work' : (
                                  (($row['category'] == 6) ? 'Others' : 'Unknown'))))))))); 
                                echo "<tr>";
                                echo "<td>SG-$row[sg_id]</td>
                                <td>$row[reported_by]</td>
                                <td>$row[hostel]</td>
                                <td>$row[for_place]</td>
                                <td><label>$category</label></td>
                                <td><label>$row[task_title]</label></td>
                                <td>$row[date]</td>
                                <td>$action</td>
                              </tr>";
                            }
                          }
                        }
                      else{
                        $Istmt = "SELECT q.query_id, q.date, s.rollno, q.hostel, q.room_no, q.problem_category, q.problem_statement, q.status, q.task_status 
                        FROM room_query q 
                        LEFT JOIN students_info s ON q.reported_by = s.id 
                        WHERE q.task_status IN ".$Mstmt."   
                        AND q.problem_category = " . $_SESSION['category'] . " 
                        ORDER BY q.query_id ASC;";
                        if ($_SESSION['role']=='3'){
                          $Istmt = "SELECT q.query_id, q.date, s.rollno, q.hostel, q.room_no, q.problem_category, q.problem_statement, q.status, q.task_status FROM room_query q LEFT JOIN students_info s ON q.reported_by = s.id WHERE q.status = '1' AND q.task_status IS NULL ORDER BY q.query_id DESC;";}
                          $stmt = mysqli_prepare($db, $Istmt); 
                          mysqli_stmt_execute($stmt); 
                          $result = mysqli_stmt_get_result($stmt);                       
                          while ($row = mysqli_fetch_array($result)) {                          
                          $action = $row['task_status'] == null ? "<button onclick='generate({$row['query_id']})' type='button' class='btn-m btn-gradient-success btn-fw' style='box-shadow:none; margin-left:3%'>Generate Task Id</button>" :
                          ($row['task_status'] == 0 ? "<button onclick='initiate({$row['query_id']})' type='button' class='btn-m btn-gradient-info btn-fw' style='box-shadow:none; margin-left:3%'><strong>Initiate Task</strong></button>" :
                          ($row['task_status'] == 1 ? "<button onclick='complete({$row['query_id']})' type='button' class='btn-m btn-gradient-warning btn-fw' style='box-shadow:none; margin-left:3%'><strong>Complete Task</strong></button>" :
                          "<button type='button' class='btn-m btn-gradient-success btn-fw' style='box-shadow:none; margin-left:3%'><strong>Completed</strong></button>"));
                          if($_SESSION['role']!=0){
                            $category = ($row['problem_category'] == 1) ? 'Electrical' :  (($row['problem_category'] == 2) ? 'Plumbing' : (
                              (($row['problem_category'] == 3) ? 'Carpentry' : (
                              (($row['problem_category'] == 4) ? 'Cleaning' : (
                              (($row['problem_category'] == 5) ? 'Civil Work' : (
                              (($row['problem_category'] == 6) ? 'Others' : 'Unknown'))))))))); 
                            echo "<tr>";
                            echo "<td>RQ-$row[query_id]</td>
                            <td>$row[rollno]</td>
                            <td>$row[hostel]</td>
                            <td>$row[room_no]</td>
                            <td><label>$category</label></td>
                            <td><label>$row[problem_statement]</label></td>
                            <td>$row[date]</td>
                            <td>$action</td>
                          </tr>";
                        }
                      }
                    }
                  }
                  else{
                    $Istmt = "SELECT q.query_id, q.date, s.rollno, q.hostel, q.room_no, q.problem_category, q.problem_statement, q.status, q.task_status 
                        FROM room_query q 
                        LEFT JOIN students_info s ON q.reported_by = s.id 
                        WHERE q.task_status IN ".$Mstmt."   
                        AND q.problem_category = " . $_SESSION['category'] . " 
                        ORDER BY q.query_id ASC;";
                        if ($_SESSION['role']=='3'){
                          $Istmt = "SELECT q.query_id, q.date, s.rollno, q.hostel, q.room_no, q.problem_category, q.problem_statement, q.status, q.task_status FROM room_query q LEFT JOIN students_info s ON q.reported_by = s.id WHERE q.status = '1' AND q.task_status IS NULL ORDER BY q.query_id DESC;";}
                          $stmt = mysqli_prepare($db, $Istmt); 
                          mysqli_stmt_execute($stmt); 
                          $result = mysqli_stmt_get_result($stmt);                       
                          while ($row = mysqli_fetch_array($result)) {                          
                          $action = $row['task_status'] == null ? "<button onclick='generate({$row['query_id']})' type='button' class='btn-m btn-gradient-success btn-fw' style='box-shadow:none; margin-left:3%'>Generate Task Id</button>" :
                          ($row['task_status'] == 0 ? "<button onclick='initiate({$row['query_id']})' type='button' class='btn-m btn-gradient-info btn-fw' style='box-shadow:none; margin-left:3%'><strong>Initiate Task</strong></button>" :
                          ($row['task_status'] == 1 ? "<button onclick='complete({$row['query_id']})' type='button' class='btn-m btn-gradient-warning btn-fw' style='box-shadow:none; margin-left:3%'><strong>Complete Task</strong></button>" :
                          "<button type='button' class='btn-m btn-gradient-success btn-fw' style='box-shadow:none; margin-left:3%'><strong>Completed</strong></button>"));
                          if($_SESSION['role']!=0){
                            $category = ($row['problem_category'] == 1) ? 'Electrical' :  (($row['problem_category'] == 2) ? 'Plumbing' : (
                              (($row['problem_category'] == 3) ? 'Carpentry' : (
                              (($row['problem_category'] == 4) ? 'Cleaning' : (
                              (($row['problem_category'] == 5) ? 'Civil Work' : (
                              (($row['problem_category'] == 6) ? 'Others' : 'Unknown'))))))))); 
                            echo "<tr>";
                            echo "<td>RQ-$row[query_id]</td>
                            <td>$row[rollno]</td>
                            <td>$row[hostel]</td>
                            <td>$row[room_no]</td>
                            <td><label>$category</label></td>
                            <td><label>$row[problem_statement]</label></td>
                            <td>$row[date]</td>
                            <td>$action</td>
                          </tr>";
                  }
                }
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
      var selectElement1 = document.getElementById('category1');
      selectElement1.addEventListener('change', function() {
        var selectedValue1 = selectElement1.value;
        window.location.href = "./index.php?category="+selectedValue1;
      });
      var selectElement = document.getElementById('category2');
      selectElement.addEventListener('change', function() {
        var selectedValue = selectElement.value;
        window.location.href = "./index.php?sorted="+selectedValue;
      });


    $(document).ready(function() {
    var table = $('#example').DataTable( {
        "order": [[ 7, "desc" ]],
        responsive: true,
        lengthChange: false,
        buttons: [ 'csv', 'excel', 'pdf', 'colvis' ]
    } );
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );

function view(id_no){
        let id = id_no;
        idh= id.toString(8);
        window.location.href = "./view.php?id=" + id;
    }
      function suggestion_generate(qid){
      var id = qid;
      var form_data = new FormData();
      form_data.append('q_id',id);
      $.ajax({
          url : './../../api/tasks/suggestion_generate.php',
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
                  location.reload();
              } else if (result.success === false) {
                  alert(result.message);
              }
          },
          error: function (err) {
              console.log(err);
          }
        });
      }
      function suggestion_initiate(qid){
          var id = qid;
          var form_data = new FormData();
          form_data.append('q_id',id);
          $.ajax({
              url : './../../api/tasks/suggestion_initiate.php',
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
                      location.reload();
                  } else if (result.success === false) {
                      alert(result.message);
                  }
              },
              error: function (err) {
                  console.log(err);
              }
          });
      }
      function suggestion_complete(qid){
          var id = qid;
          var form_data = new FormData();
          form_data.append('q_id',id);
          $.ajax({
              url : './../../api/tasks/suggestion_complete.php',
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
                      location.reload();
                  } else if (result.success === false) {
                      alert(result.message);
                  }
              },
              error: function (err) {
                  console.log(err);
              }
          });
      }
    function generate(qid){
    var id = qid;
    var form_data = new FormData();
    form_data.append('q_id',id);
    $.ajax({
        url : './../../api/tasks/generate.php',
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
                location.reload();
            } else if (result.success === false) {
                alert(result.message);
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
}
function initiate(qid){
    var id = qid;
    var form_data = new FormData();
    form_data.append('q_id',id);
    $.ajax({
        url : './../../api/tasks/initiate.php',
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
                location.reload();
            } else if (result.success === false) {
                alert(result.message);
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
}
function complete(qid){
    var id = qid;
    var form_data = new FormData();
    form_data.append('q_id',id);
    $.ajax({
        url : './../../api/tasks/complete.php',
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
                location.reload();
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
