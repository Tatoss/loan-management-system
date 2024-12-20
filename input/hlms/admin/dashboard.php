
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hlmsaid']==0)) {
  header('location:logout.php');
  } else{



  ?><!DOCTYPE html>
<html lang="en">

<head>
  
  <title>Enterwise Loan Management System || Dashboard</title>
  <!-- base:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css"/>
  <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="vendors/jquery-bar-rating/fontawesome-stars-o.css">
  <link rel="stylesheet" href="vendors/jquery-bar-rating/fontawesome-stars.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  
</head>
<body>
  <div class="container-scroller">
   
    <?php include_once('includes/header.php');?>
  
    <div class="container-fluid page-body-wrapper">
     
      <?php include_once('includes/sidebar.php');?>
     
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
              <?php
$aid=$_SESSION['hlmsaid'];
$sql="SELECT AdminName,Email from  tbladmin where ID=:aid";
$query = $dbh -> prepare($sql);
$query->bindParam(':aid',$aid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
              <h4 class="font-weight-bold text-dark">Hi, welcome back! <?php  echo $row->AdminName;?></h4>
              <?php $cnt=$cnt+1;}} ?>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
              <div class="row flex-grow">
                <div class="col-sm-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                         <?php 
                        $sql1 ="SELECT * from  tbluser";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$totuser=$query1->rowCount();
?>
                          <h4 class="card-title">Total Reg Users</h4>
                          <h4><?php echo htmlentities($totuser);?></h4>
                           <a href="reg-users.php"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                          
                      </div>
                    </div>
                    <div class="col-sm-12 grid-margin stretch-card">
                    <div class="card">
                     <div class="card-body">
                         <?php 
                        $sql2 ="SELECT * from  tblapplication where Status is null";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$results2=$query2->fetchAll(PDO::FETCH_OBJ);
$newloanapp=$query2->rowCount();
?>
                          <h4 class="card-title">New Loan Application</h4>
                          <h4><?php echo htmlentities($newloanapp);?></h4>
                           <a href="new-loan-request.php"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                          
                      </div>
                    </div>
                    
                </div>
                <div class="col-sm-12 grid-margin stretch-card">
                    <div class="card">
                     <div class="card-body">
                         <?php 
                        $sql3 ="SELECT * from  tblapplication where Status='Approved'";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
$apploanapp=$query3->rowCount();
?>
                          <h4 class="card-title">Approved Loan Application</h4>
                          <h4><?php echo htmlentities($apploanapp);?></h4>
                           <a href="new-disbursed-request.php"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                          
                      </div>
                    </div>
                    
                </div>
                <div class="col-sm-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                         <?php 
                        $sql4 ="SELECT * from  tblapplication where Status='Rejected'";
$query4 = $dbh -> prepare($sql4);
$query4->execute();
$results4=$query4->fetchAll(PDO::FETCH_OBJ);
$rejloanapp=$query4->rowCount();
?>
                          <h4 class="card-title">Rejected Loan Application</h4>
                          <h4><?php echo htmlentities($rejloanapp);?></h4>
                           <a href="rejected-loan-request.php"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                          
                      </div>
                    </div>
                    
                </div>
                </div>

                <div class="col-sm-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                         <?php 
                        $sql5 ="SELECT * from  tblapplication where Status='Disbursed'";
$query5 = $dbh -> prepare($sql5);
$query5->execute();
$results5=$query5->fetchAll(PDO::FETCH_OBJ);
$disloanapp=$query5->rowCount();
?>
                          <h4 class="card-title">Disbursed Loan Application</h4>
                          <h4><?php echo htmlentities($disloanapp);?></h4>
                           <a href="completed-disburesd-request.php"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                          
                      </div>
                    </div>
                    <div class="col-sm-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                         <?php 
                        $sql6 ="SELECT * from  tblcontact where IsRead is null";
$query6 = $dbh -> prepare($sql6);
$query6->execute();
$results6=$query6->fetchAll(PDO::FETCH_OBJ);
$unreadenq=$query6->rowCount();
?>
                          <h4 class="card-title">Unread Enquiry</h4>
                          <h4><?php echo htmlentities($unreadenq);?></h4>
                           <a href="unread-enquiry.php"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                          
                      </div>
                    </div>
                    
                </div>
                <div class="col-sm-12 grid-margin stretch-card">
                    <div class="card">
                     <div class="card-body">
                         <?php 
                        $sql7 ="SELECT * from  tblcontact where IsRead='1'";
$query7 = $dbh -> prepare($sql7);
$query7->execute();
$results7=$query7->fetchAll(PDO::FETCH_OBJ);
$readenq=$query7->rowCount();
?>
                          <h4 class="card-title">Read Enquiry</h4>
                          <h4><?php echo htmlentities($readenq);?></h4>
                           <a href="read-enquiry.php"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                          
                      </div>
                    </div>
                    
                </div>
                
                </div>

              </div>

            </div>
           
          </div>
        
        </div>
        <!-- content-wrapper ends -->
      
       <?php include_once('includes/footer.php');?>
      
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html><?php } ?>

