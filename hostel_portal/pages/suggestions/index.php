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
                          <option value="0">All</option>
                          <option value="1">Hostel</option>
                          <option value="2">Pathway</option>
                          <option value="3">Students Center</option>
                          <option value="4">Laundry</option>
                          <option value="5">Mini Canteen</option>                        
                          <option value="7">Marked</option>                        
                        </select>
                  </nav>
                    </div>
                    <div class="tb-responsive">
                    <table class="table stripe hover row-border order-column" id="example">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Reported By</th>
                          <th>Hostel</th>
                          <th>For Place</th>
                          <th>Suggestion Title</th>
                          <th>Date</th>
                          <th>Action</th>
                          <th>Likes</th>
                        </tr>
                      </thead>
                      <tbody id="table_body">
                        <?php
                        $resolve='';
                        $Istmt = '';

                          $Istmt = "SELECT q.sg_id, s.rollno, q.hostel, q.for_place, q.suggestion_title, q.`date`,q.`status`,
                                        SUM(CASE WHEN l.`action` = '1' THEN 1 ELSE 0 END) AS num_likes,
                                        IF(SUM(CASE WHEN l.user_id = $_SESSION[user_id] AND l.`action` = '1' THEN 1 ELSE 0 END) > 0, 'liked', 'not_liked') AS user_like_status
                                    FROM suggestions q
                                    LEFT JOIN students_info s ON q.reported_by = s.id
                                    LEFT JOIN likes l ON q.sg_id = l.post_id  WHERE q.`status` = '0'
                                    GROUP BY q.sg_id, s.rollno, q.hostel, q.for_place, q.suggestion_title, q.`date`
                                    ORDER BY q.sg_id DESC;";
                          $stmt = mysqli_prepare($db, $Istmt);
                          mysqli_stmt_execute($stmt);
                          $result = mysqli_stmt_get_result($stmt);

                        while ($row = mysqli_fetch_array($result)) {
                          if (($row['for_place'] == '1') &&($row['hostel'] != $_SESSION['hostel']))
                            continue;
                          if ($_SESSION['role']== '2')
                          $action = "<button onclick='mark($row[sg_id])' type='button' class='btn-m btn-gradient-warning btn-fw' style='box-shadow:none; margin-left:3%'>Mark</button>";
                          else{  
                          $class_name = ($row['user_like_status'] == 'liked') ? '' : '-outline';
                          $action = "<button type='button' class='btn btn-inverse-primary btn-rounded btn-icon' onclick=like($row[sg_id])><i id='s$row[sg_id]' class='mdi mdi-thumb-up$class_name'></i></button>";
                          }
                          $for_place = ($row['for_place'] == 1) ? 'Hostel' : (($row['for_place'] == 2) ? 'Pathway' : (($row['for_place'] == 3) ? 'Student Center' : (($row['for_place'] == 4) ? 'Laundry' : 'Mini Canteen')));
                          echo "<tr>";
                          echo "<td>SG-$row[sg_id]</td>
                                <td>$row[rollno]</td>
                                <td>$row[hostel]</td>
                                <td><label>$for_place</label></td>
                                <td><label>$row[suggestion_title]</label></td>
                                <td>$row[date]</td>
                                <td><button onclick='view($row[sg_id])' type='button' class='btn-m btn-gradient-primary btn-fw' style='margin-right:4px;'>View</button>$action</td>
                                <td><span id='lc$row[sg_id]' style='cursor:auto; color:#128fc8;' class='btn btn-icon'>$row[num_likes]</span></td>
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


function like(id){
  var action;
  var sid = "#s" + id;
  var lid = "#lc" + id;
  var action = $(sid).hasClass('mdi-thumb-up-outline') ? 'liked' : 'not_liked';
  var value = $(sid).hasClass('mdi-thumb-up-outline') ? '1' : '0';
  $.ajax({
      url: './../../api/suggestions/action.php',
      method: 'POST',
      data: {
        post_id: id,
        action: action,
        value: value
      },
      success: function(result) {
        var response = JSON.parse(result);
        console.log(response.count);
          if (action == 'not_liked')
          $(sid).removeClass('mdi-thumb-up').addClass('mdi-thumb-up-outline');
          if (action == 'liked')
          $(sid).removeClass('mdi-thumb-up-outline').addClass('mdi-thumb-up');    

          $(lid).html(response.count);
          table.destroy();
          dtable();

      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  }


  $("#category").on("change", function() {
  var selectedValue = $(this).val();
  var form_data = new FormData();
  
  form_data.append("forplace", selectedValue);
  
  console.log(selectedValue);
  
  $.ajax({
    url: './../../api/suggestions/getsuggestions.php',
    method: 'POST',
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function(result) {
      if (result.success === true) {
        var check = result.role;
        console.log(check);
        var user_hostel = result.hostel;
        table.destroy();
        $('#table_body').empty();
        
        let data = result.data;
        
        data.forEach(element => {
          var action_button = '';
          let class_name = (element.user_like_status === 'liked') ? '' : '-outline';
          if (check == '0')
          action_button = `<button type='button' class='btn btn-inverse-primary btn-rounded btn-icon' onclick='like(${element.sg_id})'><i id='s${element.sg_id}' class='mdi mdi-thumb-up${class_name}'></i></button>`;
          if (check == 2 && selectedValue!= 7)
          action_button = `<button onclick='mark(${element.sg_id})' type='button' class='btn-m btn-gradient-warning btn-fw' style='box-shadow:none; margin-left:3%'>Mark</button>`

          console.log(selectedValue);
          console.log(user_hostel);
          console.log(element.hostel);
          if ((element.for_place === '1' )&& user_hostel !== element.hostel) {
          return;
        }
      
          let for_place = (element.for_place === '1') ? 'Hostel' :
              ((element.for_place === '2') ? 'Pathway' :
              ((element.for_place === '3') ? 'Student Center' :
              ((element.for_place === '4') ? 'Laundry' :
              'Mini Canteen')));
          
          $('#table_body').append(`
            <tr>
              <td>SG-${element.sg_id}</td>
              <td>${element.rollno}</td>
              <td>${element.hostel}</td>
              <td><label>${for_place}</label></td>
              <td><label>${element.suggestion_title}</label></td>
              <td>${element.date}</td>
              <td><button onclick='view(${element.sg_id})' type='button' class='btn-m btn-gradient-primary btn-fw'>View</button>${action_button}</td>
              <td><span id='lc${element.sg_id}' style='cursor:auto; color:#128fc8;' class='btn btn-icon'>${element.num_likes}</span></td>
            </tr>;
          `);
        });
        
        dtable();
      }
      
      if (result.success === false) {
        alert(result.message);
      }
    },
    error: function(err) {
      console.log(err);
    }
  });
});

function view(id_no){
        let id = id_no;
        idh= id.toString(8);
        window.location.href = "./view.php?id=" + id;
    }

  function mark(id_no){
      let id = id_no;
      var encode = btoa(id);
      window.location.href = "./mark.php?id=" + encode;
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
