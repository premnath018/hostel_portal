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
    <title>Purple Admin</title>
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
                </span> Room Query List
              </h3>
            </div>
            <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Query List</h4>
                    <table class="table stripe hover row-border order-column" id="example" style="overflow-x:auto;">
                      <thead>
                        <tr>
                          <th>Query Id</th>
                          <th>Reported By</th>
                          <th>Hostel</th>
                          <th>Room No</th>
                          <th>Category</th>
                          <th>Status</th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $resolve='';
                        $Istmt = '';
                        if($_SESSION['role'] == 0){
                            $Istmt = "SELECT q.query_id,q.date,s.rollno,q.hostel,q.room_no,q.problem_category,q.problem_statement,q.resolved_by FROM room_query q left join students_info s ON q.reported_by=s.id WHERE q.room_no = ? AND q.hostel = ? ORDER BY q.query_id DESC;";
                            $stmt = mysqli_prepare($db, $Istmt); mysqli_stmt_bind_param($stmt, "ds", $_SESSION['room_no'],$_SESSION['hostel']); mysqli_stmt_execute($stmt); $result = mysqli_stmt_get_result($stmt);
                          }
                        if ($_SESSION['role']!=0 && $_SESSION['role2']){
                          $Istmt = "SELECT q.query_id,q.date,s.rollno,q.hostel,q.room_no,q.problem_category,q.problem_statement,q.resolved_by FROM room_query q left join students_info s ON q.reported_by=s.id WHERE q.hostel = ? ORDER BY q.query_id DESC;";
                          $stmt = mysqli_prepare($db, $Istmt); mysqli_stmt_bind_param($stmt, "s",$_SESSION['hostel']); mysqli_stmt_execute($stmt); $result = mysqli_stmt_get_result($stmt);
                        }
                        while ($row = mysqli_fetch_array($result)) {
                          if($_SESSION['role'] != 0 && $_SESSION['role2']==2)
                          $resolve = "<button onclick='resolve($row[query_id])' type='button' class='btn-m btn-gradient-success btn-fw' style = 'box-shadow:none; margin-left:5%'>Resolve</button>";
                          $status ='';
                          $catgory = ($row['problem_category'] == 1) ? 'Electrical' : ((($row['problem_category'] == 2) ? 'Woodworks' : 'Others'));
                          if (isset($row['resolved_by'])){$resolve=''; $status = "<td><label class='badge badge-success'>Resolved</label></td>"; }
                          else { $status = "<td><label class='badge badge-warning'>Initiated</label></td>";}
                            echo "<tr>";
                            echo "<td>RQ-$row[query_id]</td>
                            <td>$row[rollno]</td>
                            <td>$row[hostel]</td>
                            <td>$row[room_no]</td>
                            <td><label>$catgory</label></td>$status
                            <td>$row[date]</td>
                            <td><button onclick='view($row[query_id])' type='button' class='btn-m btn-gradient-primary btn-fw'>View</button>$resolve</td>
                          </tr>";
                        }
                        ?>
                      </tbody>
                    </table>
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
        "order": [[ 5, "asc" ]],
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );

function view(id_no){
        let id = id_no;
        idh= id.toString(8);
        window.location.href = "./view.php?id=" + id;
    }

    function resolve(qid){
            var id = qid;
            var form_data = new FormData();
            form_data.append('q_id',id);
            $.ajax({
                url : './../../api/roomquery/resolve.php',
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
                          window.location.href='./query_list.php';
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