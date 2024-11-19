<!-- header -->
  <header>
  <div class="top">
      <div class="container">
        <div class="t-op row">
          <div class="col-sm-6 top-middle">
            <ul>
              <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
              <li><a href="#"><i class="fab fa-twitter"></i></a></li>
              <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
              <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
            </ul>
          </div>
          <div class="col-sm-6 top-left">
            <ul>
              
              <?php if (strlen($_SESSION['hlmsuid']==0)) {?>
               <li class="nav-item  mr-3">
              <a class="nav-link" href="sign-up.php" style="color:#fff;">Sign Up</a>
            </li>
              <li class="nav-item  mr-3">
              <a class="nav-link" href="sign-in.php" style="color:#fff;">Sign In</a>
            </li><?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light">
        <h1>
         <a href="index.php">
        <img src="images/log.png" alt="Logo" style="max-height: 60px; width: auto;">
      </a>
        </h1>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav text-center  ml-lg-auto">
            <li class="nav-item active  mr-3">
              <a class="nav-link" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item  mr-3">
              <a class="nav-link" href="emicalculator.php">Loan Calculator</a>
            </li>
             <li class="nav-item  mr-3">
              <a class="nav-link" href="application-form.php">Application Form</a>
            </li>
            <?php if (strlen($_SESSION['hlmsuid']!=0)) {?>
            <li class="nav-item dropdown mr-3">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
                My Account
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="profile.php">Profile</a>
                <a class="dropdown-item" href="change-password.php">Setting</a>
                <a class="dropdown-item" href="application-history.php">Application History</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li><?php } ?>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">contact</a>
            </li>
               <?php if (strlen($_SESSION['hlmsuid']==0)) {?>
            <li class="nav-item">
              <a class="nav-link" href="admin/login.php">Admin</a>
            </li>
          <?php } ?>
          </ul>
        </div>
      </nav>
    </div>
  </header>
  <!-- //header -->