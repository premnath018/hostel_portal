<?php
$db = db();
$result = mysqli_query($db, "SELECT resource FROM roles WHERE id =$_SESSION[role]");
$row = mysqli_fetch_assoc($result);
$resource = explode('-', $row['resource']);
$result = mysqli_query($db, "SELECT * FROM master_resource WHERE STATUS ='1' order by sort_id");
$menu = array();
while ($row = mysqli_fetch_assoc($result)) {
    $menu[] = $row;
}
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="./../../assets/images/faces/face1.jpg" alt="profile">
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2"><?php echo $_SESSION['name'] ?></span>
            <span class="text-secondary text-small"><?php echo $_SESSION['role'] === '0' ? 'Student' : 'Faculty'; ?></span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>
       <?php
                foreach ($menu as $item) {
                    if (in_array($item['resource_id'], $resource))
                    echo " <li class='nav-item'>
                            <a class='nav-link' href='../$item[link]'>
                              <span class='menu-title'>$item[label]</span>
                              <i class='mdi mdi-$item[img] menu-icon'></i>
                            </a>
                          </li>";
                }
        ?>
      </li>
    </ul>
  </nav>
