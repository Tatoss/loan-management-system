<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hlmsuid']==0)) {
header('location:logout.php');
  } else{



  ?>
<!DOCTYPE HTML>
<html lang="zxx">

<head>
	<title>Home Loan Management System|| Application History</title>
	
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<!-- font-awesome icons -->
	<link href="css/fontawesome-all.min.css" rel="stylesheet">
	<!-- //Custom Theme files -->
	<!-- online fonts -->
	<!-- titles -->
	<link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
	<!-- body -->
	<link href="//fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
</head>

<body>
	
<?php include_once('includes/header.php');?>
	<!-- banner -->
	<section class="banner-1">
	</section>
	<!-- //banner -->
		<!-- typography -->
	<section class="typo py-5">
		<div class="container py-md-4 mt-md-3">
		
			<div class="grid_3 grid_5 w3l">
				<h3>Loan Application History</h3>
			<div class="alert alert-success" role="alert">
				  <strong>Welcome!</strong> View Loan Application History.
				</div>
			</div>
			<div class="bs-docs-example">
		<table class="table table-striped">
                      <thead>
                       <tr>
                                               <th>S.No</th>
                                        <th>Application Number</th>
                                        <th>Name</th>
                                        <th>Mobile Number</th>
                                        <th>Pan Number</th>
                                    <th>Status</th>
                                        <th>Action</th>
                                            </tr>
                      </thead>
                      <tbody>

                                              
                        <tr class="table-info">
                           <?php
                           $uid=$_SESSION['hlmsuid'];
$sql="SELECT tbluser.FirstName,tbluser.MobileNumber,tblapplication.ID as appaid, tblapplication.ApplicationNumber, tblapplication.PanNumber,tblapplication.Status from  tblapplication join tbluser on tbluser.ID= tblapplication.UserID where tbluser.ID=:uid";
$query = $dbh -> prepare($sql);
$query->bindParam(':uid',$uid,PDO::PARAM_STR); 
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                         <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php  echo htmlentities($row->ApplicationNumber);?></td>
                                        <td><?php  echo htmlentities($row->FirstName);?></td>
                                        <td><?php  echo htmlentities($row->MobileNumber);?></td>
                                        <td><?php  echo htmlentities($row->PanNumber);?></td>
                                             <?php if($row->Status==""){ ?>

                     <td><?php echo "Not Updated Yet"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->Status);?>
                  </td>
                  <?php } ?>         
                 
                                        <td><a href="view-loan-request-detail.php?editid=<?php echo htmlentities ($row->appaid);?>&&aid=<?php echo htmlentities ($row->ApplicationNumber);?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                        </tr>
                        <?php $cnt=$cnt+1;}} ?>
                      </tbody>
                    </table>
			</div>
			<hr class="bs-docs-separator">
		</div>
	</section>
	<!-- //typography -->

<?php include_once('includes/footer.php');?>

<!-- js-->
	<script src="js/jquery-2.2.3.min.js"></script>
<!-- js-->
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js ">
	</script>
	<!-- //Bootstrap Core JavaScript -->
</body>
</html><?php }?>