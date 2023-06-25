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
    <title>TasksS</title>
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
                  <i class="mdi mdi-home"></i>
                </span> Task List
              </h3>
            </div>
            <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Queued Tasks</h4>
                    <div class="tb-responsive">
                    <table class="table stripe hover row-border order-column" id="example" >
                      <thead>
                        <tr>
                          <th>Query Id</th>
                          <th>Reported By</th>
                          <th>Hostel</th>
                          <th>Room No</th>
                          <th>Category</th>
                          <th>Problem Statement</th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                       
                        $task_status = $_SESSION['role2'] == 4 ? 0 : ($_SESSION['role2'] == 5 ? 1 : null);
                        $Istmt = "SELECT q.query_id, q.date, s.rollno, q.hostel, q.room_no, q.problem_category, q.problem_statement, q.resolved_by, q.status FROM room_query q LEFT JOIN students_info s ON q.reported_by = s.id WHERE q.task_status" . (isset($task_status) ? " = '$task_status'" : " IS NULL") . " AND q.status = '2' AND q.problem_category = ".$_SESSION['category']." ORDER BY q.query_id DESC;";
                        if ($_SESSION['role']=='3'){
                          $Istmt = "SELECT q.query_id, q.date, s.rollno, q.hostel, q.room_no, q.problem_category, q.problem_statement, q.resolved_by, q.status FROM room_query q LEFT JOIN students_info s ON q.reported_by = s.id WHERE q.task_status" . (isset($task_status) ? " = '$task_status'" : " IS NULL") . " AND q.status = '2' AND q.task_status IS NULL ORDER BY q.query_id DESC;";}
                          $stmt = mysqli_prepare($db, $Istmt); mysqli_stmt_execute($stmt); $result = mysqli_stmt_get_result($stmt);                       
                          while ($row = mysqli_fetch_array($result)) {
                          $action = $_SESSION['role2'] == 3 ? "<button onclick='generate({$row['query_id']})' type='button' class='btn-m btn-gradient-success btn-fw' style='box-shadow:none; margin-left:3%'>Generate Task Id</button>" :
                          ($_SESSION['role2'] == 4 ? "<button onclick='initiate({$row['query_id']})' type='button' class='btn-m btn-gradient-info btn-fw' style='box-shadow:none; margin-left:3%'>Initiate Task</button>" :
                          ($_SESSION['role2'] == 5 ? "<button onclick='complete({$row['query_id']})' type='button' class='btn-m btn-gradient-warning btn-fw' style='box-shadow:none; margin-left:3%'>Complete Task</button>" :
                          ""));
                          if($_SESSION['role'] !=0){
                          $catgory = ($row['problem_category'] == 1) ? 'Electrical' : ((($row['problem_category'] == 2) ? 'Carpentary' : 'Others'));
                            echo "<tr>";
                            echo "<td>RQ-$row[query_id]</td>
                            <td>$row[rollno]</td>
                            <td>$row[hostel]</td>
                            <td>$row[room_no]</td>
                            <td><label>$catgory</label></td>
                            <td><label>$row[problem_statement]</label></td>
                            <td>$row[date]</td>
                            <td>$action</td>
                          </tr>";
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
