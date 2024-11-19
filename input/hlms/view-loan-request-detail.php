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
			<div>
		<?php
                  $eid=$_GET['editid'];
$sql="SELECT tbluser.FirstName,tbluser.MobileNumber,tblapplication.ID, tblapplication.ApplicationNumber, tblapplication.PanNumber,tblapplication.PanCardCopy,tblapplication.Address,tblapplication.AddressProofType,tblapplication.AdressDoc,tblapplication.ServiceType,tblapplication.MontlyIncome,tblapplication.ExistingLoan,tblapplication.ExpectedLoanAmount,tblapplication.ProfilePic,tblapplication.Tenure,tblapplication.SubmitDate,tblapplication.Remark,tblapplication.UpdationDate,tblapplication.Status,tblapplication.GName,tblapplication.Gmobnum,tblapplication.Gemail,tblapplication.Gaddress,tblapplication.LoanamountDisbursed,RateofInterest,DTenure from  tblapplication join tbluser on tbluser.ID= tblapplication.UserID where tblapplication.ID=:eid";
$query = $dbh -> prepare($sql);
$query-> bindParam(':eid', $eid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                    <table class="table table-bordered">
                      <tr><th colspan="6"><img src="images/<?php echo $row->ProfilePic;?>" width="200" height="200"></th></tr>
                      <tr>
    <th colspan="6" style="color: orange;font-weight: bold;font-size: 20px;">Application Number: <?php  echo $applicationno=($row->ApplicationNumber);?> </th>
  </tr>
  
  <tr>
    <th>First Name</th>
    <td><?php  echo $row->FirstName;?></td>
     <th>Mobile Number</th>
    <td><?php  echo $row->MobileNumber;?></td>
   <th>Employment Type</th>
    <td><?php  echo $row->ServiceType;?></td>
  </tr>
   <tr>

    <th>ID Number</th>
    <td><?php  echo $row->PanNumber;?></td>
    <th>Copy of ID </th>
    <td style="text-align: center;" colspan="3"><a href="../pancardfile/<?php echo $row->PanCardCopy;?>"  width="100" height="100" target="_blank"> <strong style="color: red">View Copy of ID</strong></a></td>
  </tr>
  
  <tr>
        <th>Address</th>
    <td><?php  echo $row->Address;?></td>
    <th>Address Proof Doc</th>
    <td  style="text-align: center;"><a href="../addfile/<?php echo $row->AdressDoc;?>"  width="100" height="100" target="_blank"> <strong style="color: red">View Proof of Address Document</strong></a></td>
    <th>Type of Address Proof</th>
   <td><?php  echo $row->AddressProofType;?></td>

  </tr>
  <tr>
    
    <th>Montly Income</th>
    <td><?php  echo $row->MontlyIncome;?></td>
    <th>Existing Loan</th>
    <td><?php  echo $row->ExistingLoan;?></td>
    <th>Expected Loan Amount</th>
    <td><?php  echo $row->ExpectedLoanAmount;?></td>
  </tr>
 
  <tr>
    
    <th>Loan period</th>
    <td><?php  echo $row->Tenure;?></td>
    <th>Date of Application</th>
    <td><?php  echo $row->SubmitDate;?></td>
     <th>Disbursed Loan Amount</th>
    <td><?php  echo $row->LoanamountDisbursed;?></td>
  </tr>
  <tr>
    
   
    <th> Final Status</th>
   <td> <?php  $status=$row->Status;
    
if($row->Status=="Approved")
{
  echo "Your request has been approved";
}

else if($row->Status=="Rejected")
{
 echo "Your request has been rejected";
}

else if($row->Status=="")
{
  echo "Not Response Yet";
} else {
echo htmlentities($row->Status);
} ?></td>
    <th>Enterwise Remark</th>
    <?php if($row->Status==""){ ?>
<td  colspan="4"><?php echo "Not Updated Yet"; ?></td>
<?php } else { ?>                  
  <td colspan="4"><?php  echo htmlentities($row->Remark);?>
                  </td>
                  <?php } ?>  

  </tr>
<tr>
    <th colspan="6" style="color: orange;font-weight: bold;font-size: 20px;text-align: center;">Next of kin  Info</th>
      </tr>
   <tr>
    <th>Next of kin  Name</th>
    <td><?php  echo $row->GName;?></td>
    <th>Guarantor Mobile Number</th>
   <td colspan="4"><?php  echo $row->Gmobnum;?></td></tr>
    <tr>
    <th>Next of kin  Email</th>
  <td><?php  echo $row->Gemail;?></td>
  <th>Next of kin  Address</th>
  <td colspan="4"><?php  echo $row->Gaddress;?></td></tr>
  </table>
  <table class="table table-bordered">
<tr>
    <th colspan="6" style="color: orange;font-weight: bold;font-size: 20px;text-align: center;">Disburesed Amount Info</th>
      </tr>
<?php if($row->Status=="Disbursed"){ ?>

<tr>
    <th>Amount of Loan Disbursed</th>

    <td><?php  echo $dloan=$row->LoanamountDisbursed;?></td>

      <th>Date of Dibursement</th>
    <td><?php  echo $row->UpdationDate;?></td></tr>

    <tr>
    <th>Disbursement Tenure</th>
    <td><?php  echo $ltenure=$row->DTenure;?> Years</td>
    <th>Rate of Interest</th>
    <td><?php  echo $lroi=$row->RateofInterest;?> % </td></tr>
    <tr>
    <?php 
$rate = $lroi/12; //converting int to month
$time=$ltenure*12; // Converting in to month
$simpleinterst=($rate*$time*$dloan)/100;
?>
       <tr>
<th>Total interest</th>
<td><?php echo $simpleinterst?></td>
<th>Total Payable Amount<br />
Principle + Interest</th>
<td><?php echo $totalpayable=$simpleinterst+$dloan?></td>
  </tr>             
   
          <tr>
<th>Monthly EMI</th>
<td><?php echo round($totalpayable/$time,2);?></td>
<th>Total EMI Installments</th>
<td><?php echo $time;?></td>
  </tr>             

    <?php } else { ?>
    <tr>                  
  <td  colspan="4" style="font-size: 20px;text-align: center;color: red"><?php echo "Not Updated Yet"; ?></td>
   <?php } ?> </tr>
  <?php $cnt=$cnt+1;}} ?>

 </table>




                                     <?php 
$aid=$_GET['aid']; 
   if($status!=""){
$ret="select tblapplicationtracking.Remark,tblapplicationtracking.Status,tblapplicationtracking.UpdationDate from tblapplicationtracking where tblapplicationtracking.ApplicationNumber =:aid";
$query = $dbh -> prepare($ret);
$query-> bindParam(':aid', $aid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
 ?>
<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
  <tr align="center">
   <th colspan="4" style="color: blue" >Tracking History</th> 
  </tr>
  <tr>
    <th>#</th>
<th>Remark</th>
<th>Status</th>
<th>Time</th>
</tr>
<?php  
foreach($results as $row)
{               ?>
<tr>
  <td><?php echo $cnt;?></td>
 <td><?php  echo $row->Remark;?></td> 
  <td><?php  echo $row->Status;
?></td> 
   <td><?php  echo $row->UpdationDate;?></td> 
</tr>
<?php $cnt=$cnt+1;} ?>
</table>
<?php  }  
?>
			</div>
			
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