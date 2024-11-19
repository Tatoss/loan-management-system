<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE HTML>
<html lang="zxx">

<head>
	<title>Home Loan Management System|| About Us Page</title>

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
	<!-- about -->
	<section class="welcome py-5">
		<div class="container py-md-4 mt-md-3">
			<h2 class="heading-agileinfo">About Us <span>Speed Up the Loan Process</span></h2>
			<span class="w3-line black"></span>
			<div class="row about-tp mt-md-5 pt-5">
				<div class="col-lg-6 welcome-left">
					<h3>Welcome</h3>
					<?php
$sql="SELECT * from tblpage where PageType='aboutus'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
					
					<p><?php  echo htmlentities($row->PageDescription);?>.</p> <?php $cnt=$cnt+1;}} ?>
				</div>
				<div class="col-lg-6 welcome-right">
					<div class="welcome-right-top">
						<img src="images/g1.jpg" alt="" class="img-fluid">
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- //about -->
	<!-- w3layouts_bottom -->
<section class="w3layouts_bottom">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 w3layouts_getin_info">
				<h3>Don’t Miss Your Perfect House!</h3>
			</div>
			<div class="col-lg-3 w3layouts_getin">
				<a href="contact.php">Contact Us</a>
			</div>
		</div>
	</div>
</section>
<!-- //w3layouts_bottom -->

	
<?php include_once('includes/footer.php');?>

<!-- js-->
	<script src="js/jquery-2.2.3.min.js"></script>
<!-- js-->
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js ">
	</script>
	<!-- //Bootstrap Core JavaScript -->
</body>
</html>