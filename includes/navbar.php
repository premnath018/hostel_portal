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
      <li class="nav-item">
        <a class="nav-link" href="../dashboard">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-buffer menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#room-query" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Room Query</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
        <div class="collapse" id="room-query">
          <ul class="nav flex-column sub-menu">
            <?php if ($_SESSION['role']!=0){echo 
               '<li class="nav-item"> <a class="nav-link" href="../roomquery/query_list.php">Query List</a></li>
               <li class="nav-item"> <a class="nav-link" href="../roomquery/resolved_list.php">Resolve Queries</a></li>';
            }
            else{ echo
            '<li class="nav-item"> <a class="nav-link" href="../roomquery/query_add.php">Create Query</a></li>
            <li class="nav-item"> <a class="nav-link" href="../roomquery/query_list.php">Query List</a></li>
            <li class="nav-item"> <a class="nav-link" href="../roomquery/resolved_list.php">Resolved Query</a></li>';
            }
            ?>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#drop-down2" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Suggestions</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-help-circle menu-icon"></i>
        </a>
        <div class="collapse" id="drop-down2">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Create Suggestions</a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Suggestions List</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#drop-down3" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Mess Queries</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-food menu-icon"></i>
        </a>
        <div class="collapse" id="drop-down3">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Daily Food Rating</a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Mess Suggestions</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pages/forms/basic_elements.html">
          <span class="menu-title">Informations</span>
          <i class="mdi mdi-format-list-bulleted menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../api/auth/logout.php">
          <span class="menu-title">Log Out</span>
          <i class="mdi mdi-logout menu-icon"></i>
        </a>
      </li>
      </li>
    </ul>
  </nav>
