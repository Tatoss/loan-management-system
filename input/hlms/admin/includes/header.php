<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
         <a href="index.php">
        <img src="../images/log.png" alt="Logo" style="max-height: 60px; width: auto;">
      </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
       
        <ul class="navbar-nav navbar-nav-right">
           
          <li class="nav-item dropdown d-flex">
            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
              <i class="icon-air-play mx-0"></i>
            </a>
             <?php
$sql="SELECT tbluser.FirstName, tblapplication.ApplicationNumber,tblapplication.SubmitDate, tblapplication.Status,tblapplication.ID as appaid from  tblapplication join tbluser on tbluser.ID= tblapplication.UserID where Status is null";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
$newapp=$query->rowCount();
?>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Notification(<?php echo $newapp;?>)</p>
              <?php foreach($results as $row)
{ ?>
              <a href="view-loan-request-detail.php?editid=<?php echo htmlentities ($row->appaid);?>&&aid=<?php echo htmlentities ($row->ApplicationNumber);?>" class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="images/faces/portfolio.png" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h6 class="preview-subject ellipsis font-weight-normal"><?php echo $row->FirstName;?>(<?php echo $row->ApplicationNumber;?>)
                  </h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                    <?php echo $row->SubmitDate;?>
                  </p>
                </div>
              </a>
             <?php  } ?>
            </div>
          </li>
          <li class="nav-item dropdown d-flex mr-4 ">
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Settings</p>
              <a href="profile.php" class="dropdown-item preview-item">               
                  <i class="icon-head"></i> Profile
              </a>
              <a href="change-password.php" class="dropdown-item preview-item">
                  <i class="icon-cog"></i> Change Password
              </a>
              <a href="logout.php" class="dropdown-item preview-item">
                  <i class="icon-inbox"></i> Logout
              </a>
            </div>
          </li>
         
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>