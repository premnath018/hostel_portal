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
    <title>Suggestions</title>
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
                </span> Suggestions
              </h3>
              <?php
              if ($_SESSION['role']== '0'){
             echo "<h3 class='page-title'>
              <a href='./create.php' class='page-title-icon bg-gradient-primary text-white'>
                <i class='mdi mdi-plus'></i>
              </a>
              </h3>";}
              ?>
              </div>
            <div class="card">
                  <div class="card-body">
                    <div class="page-header">
                    <h4 class="page-title">Suggestions List</h4>
                    <nav aria-label="breadcrumb">
                        <select id="category" class=" form-control">
                          <option value="9">All</option>
                          <option value="1">Submitted</option>
                          <option value="0">Rejected</option>
                          <option value="2">In Progress</option>
                          <option value="3">Completed</option>
                          <option value="4">Closed</option>                        
                        </select>
                  </nav>
                    </div>
                    <div class="tb-responsive">
                    <table class="table stripe hover row-border order-column" id="example" >
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Reported By</th>
                          <th>Hostel</th>
                          <th>For Place</th>
                          <th>Suggestion Title</th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="table_body">
                        <?php 
                        $resolve='';
                        $Istmt = '';
                        if($_SESSION['role'] == 0){
                            $Istmt = "SELECT q.sg_id,q.date,s.rollno,q.hostel,q.for_place,q.suggestion_title FROM suggestions q left join students_info s ON q.reported_by=s.id  AND q.hostel = ? ORDER BY q.sg_id DESC;";
                            $stmt = mysqli_prepare($db, $Istmt); mysqli_stmt_bind_param($stmt, "s",$_SESSION['hostel']); mysqli_stmt_execute($stmt); $result = mysqli_stmt_get_result($stmt);
                          }
                        if ($_SESSION['role']!=0 && $_SESSION['role2']){
                          $Istmt = "SELECT q.query_id,q.date,s.rollno,q.hostel,q.room_no,q.problem_category,q.problem_statement,q.resolved_by,q.status FROM room_query q left join students_info s ON q.reported_by=s.id WHERE q.hostel = ? ORDER BY q.query_id DESC;";
                          $stmt = mysqli_prepare($db, $Istmt); mysqli_stmt_bind_param($stmt, "s",$_SESSION['hostel']); mysqli_stmt_execute($stmt); $result = mysqli_stmt_get_result($stmt);
                        }
                        while ($row = mysqli_fetch_array($result)) {$upvote = "
                          <button type='button' class='btn btn-inverse-primary btn-rounded btn-icon'>
                          <i class='mdi mdi-thumb-up-outline'></i>
                        </button>";
                          $for_place = ($row['for_place'] == 1) ? 'Hostel' : (($row['for_place'] == 2) ? 'Pathway' : (($row['for_place'] == 3) ? 'Student Center' : (($row['for_place'] == 4) ? 'Laundry' : 'Mini Canteen')));                            echo "<tr>";
                            echo "<td>SG-$row[sg_id]</td>
                            <td>$row[rollno]</td>
                            <td>$row[hostel]</td>
                            <td><label>$for_place</label></td>
                            <td><label>$row[suggestion_title]</label></td>
                            <td>$row[date]</td>
                            <td><button onclick='view($row[sg_id])' type='button' class='btn-m btn-gradient-primary btn-fw' style='margin-right:4px;'>View</button>$upvote</td>
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
  dtable();
     var table;
     function dtable(){
     table = $('#example').DataTable( {
         "order": [[ 0, "desc" ]],
         responsive: true,
         lengthChange: false,
         buttons: [ 'csv', 'excel', 'pdf']
     } );
     table.buttons().container()
         .appendTo( '#example_wrapper .col-md-6:eq(0)' );
    }


$("#category").on("change", function() {
  var selectedValue = $(this).val();
  var form_data = new FormData();
  form_data.append("status",selectedValue);
  console.log(selectedValue);
  $.ajax({
          url : './../../api/roomquery/getquery.php',
          method : 'POST',
          dataType : 'json',
          cache : false,
          contentType : false,
          processData: false,
          data : form_data,
          success: function (result) {
                if (result.success === true) {
                  var check = result.check;
                  table.destroy();
                  $('#table_body').empty();
                    let data = result.data
                    data.forEach(element => {
                    var action = "";
                      if (( check === '2' )&& (element.status === '1')){
                      console.log("Hello");
                     action = `<button onclick='approve(${element.query_id}))' type='button' class='btn-m btn-gradient-success btn-fw' style = 'box-shadow:none; margin-left:3%'>Approve</button> <button onclick='decline(${element.query_id})' type='button' class='btn-m btn-gradient-danger btn-fw' style = 'box-shadow:none; margin-left:3%'>Decline</button>`; 
                  }
                    
                    const category = (element.problem_category === '1') ? 'Electrical' :
                   ((element.problem_category === '2') ? 'Plumbing' :
                   ((element.problem_category === '3') ? 'Carpentry' :
                   ((element.problem_category === '4') ? 'Cleaning' :
                   ((element.problem_category === '5') ? 'Civil Work' :
                   'Others'))));
                   const status = (element.status === '0') ? "danger'>Declined" :
                    ((element.status === '1') ? "success'>Submitted" :
                    ((element.status === '2') ? "warning'>In Progress" :
                    ((element.status === '3') ? "info'>Completed" :
                    ((element.status === '4') ? "success'>Closed": 
                     ""))));
                    $('#table_body').append(`
                    <tr>
                    <td>RQ-${element.query_id}</td>
                    <td>${element.rollno}</td>
                    <td>${element.hostel}</td>
                    <td>${element.room_no}</td>
                    <td><label>${category}</label></td>
                    <td><label>${element.problem_statement}</label></td>
                    <td><label class='badge badge-${status}</label></td>
                    <td>${element.date}</td>
                    <td><button onclick='view(${element.query_id})' type='button' class='btn-m btn-gradient-primary btn-fw'>View</button>${action}</td>
                  </tr>;
                    `)
                  });
                    dtable(); 
                }

                 
                  if (result.success === false) {
                      alert(result.message);
                  }
          },
          error: function (err) {
              console.log(err);
          }
      });
   
});

function view(id_no){
        let id = id_no;
        idh= id.toString(8);
        window.location.href = "./view.php?id=" + id;
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
