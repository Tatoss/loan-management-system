<nav class="sidebar sidebar-offcanvas animated fadeInLeft" id="sidebar">
  <div class="user-profile text-center">
    <?php
      $aid = $_SESSION['hlmsaid'];
      $sql = "SELECT AdminName, Email from tbladmin where ID=:aid";
      $query = $dbh->prepare($sql);
      $query->bindParam(':aid', $aid, PDO::PARAM_STR);
      $query->execute();
      $results = $query->fetchAll(PDO::FETCH_OBJ);
      $cnt = 1;
      if ($query->rowCount() > 0) {
        foreach ($results as $row) { 
    ?>
    <div class="user-image">
      <img src="images/faces/face28.png" class="animated bounceIn" alt="Admin Profile Picture">
    </div>
    <div class="user-name font-weight-bold animated fadeInUp">
      <?php echo $row->AdminName; ?>
    </div>
    <div class="user-designation text-muted animated fadeInUp">
      <?php echo $row->Email; ?>
    </div>
    <?php $cnt++; } } ?>
  </div>

  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link animated fadeInLeft delay-1s" href="dashboard.php">
        <i class="icon-box menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link animated fadeInLeft delay-2s" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="icon-disc menu-icon"></i>
        <span class="menu-title">Loan Request</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="new-loan-request.php">New Loan</a></li>
          <li class="nav-item"> <a class="nav-link" href="all-loan-request.php">All Loan</a></li>
          <li class="nav-item"> <a class="nav-link" href="rejected-loan-request.php">Rejected Loan</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link animated fadeInLeft delay-3s" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
        <i class="icon-disc menu-icon"></i>
        <span class="menu-title">Payment Request</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic1">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="new-disbursed-request.php">New Request</a></li>
          <li class="nav-item"> <a class="nav-link" href="completed-disburesd-request.php">Completed Request</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link animated fadeInLeft delay-4s" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Pages</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="auth">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="about-us.php">About Us</a></li>
          <li class="nav-item"> <a class="nav-link" href="contact-us.php">Contact Us</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link animated fadeInLeft delay-5s" href="between-dates-reports.php">
        <i class="icon-help menu-icon"></i>
        <span class="menu-title">Reports</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link animated fadeInLeft delay-6s" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
        <i class="icon-disc menu-icon"></i>
        <span class="menu-title">Enquiry</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic2">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="unread-enquiry.php">Unread Enquiry</a></li>
          <li class="nav-item"> <a class="nav-link" href="read-enquiry.php">Read Enquiry</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link animated fadeInLeft delay-7s" href="search.php">
        <i class="icon-search"></i>
        <span class="menu-title" style="padding-left: 25px;">Search</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link animated fadeInLeft delay-8s" href="reg-users.php">
        <i class="icon-head"></i>
        <span class="menu-title" style="padding-left: 25px;">Manage Users</span>
      </a>
    </li>
      <li class="nav-item">
      <a class="nav-link animated fadeInLeft delay-8s" href="user-checks.php">
        <i class="icon-head"></i>
        <span class="menu-title" style="padding-left: 25px;">Verify Clients</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link animated fadeInLeft delay-9s" data-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic3">
        <i class="icon-disc menu-icon"></i>
        <span class="menu-title">Integrations</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic3">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="#">Credit Checks</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">SMS Notification</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Banks</a></li>
        </ul>
      </div>
    </li>
  </ul>
</nav>
