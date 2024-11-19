<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hlmsaid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
  {
    
    $eid=$_GET['editid'];
    $aid=$_GET['aid'];
    $status='Disbursed';
   $remark=$_POST['remark'];
   $lmd=$_POST['lmd'];
   $roi=$_POST['roi'];
   $tenure=$_POST['tenure'];

    $sql="insert into tblapplicationtracking(ApplicationNumber,Remark,Status) value(:aid,:remark,:status)";
    $query=$dbh->prepare($sql);
$query->bindParam(':aid',$aid,PDO::PARAM_STR); 
    $query->bindParam(':remark',$remark,PDO::PARAM_STR); 
    $query->bindParam(':status',$status,PDO::PARAM_STR); 
       $query->execute();
      $sql= "update tblapplication set LoanamountDisbursed=:lmd,RateofInterest=:roi,DTenure=:tenure,Status=:status,Remark=:remark where ID=:eid";

    $query=$dbh->prepare($sql);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':remark',$remark,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->bindParam(':lmd',$lmd,PDO::PARAM_STR); 
    $query->bindParam(':roi',$roi,PDO::PARAM_STR); 
    $query->bindParam(':tenure',$tenure,PDO::PARAM_STR);
 $query->execute();
 echo '<script>alert("Remark has been updated")</script>';
 echo "<script>window.location.href ='all-loan-request.php'</script>";
}
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
 
  <title>Enterwise||View Disbursed Loan Request</title>
  <!-- base:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
 
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
 <?php include_once('includes/header.php');?>
    <div class="container-fluid page-body-wrapper">
      
      <?php include_once('includes/sidebar.php');?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3 >View Disbursed Loan Request</h3>
               
                  <div class="table-responsive pt-3">

                    <?php
                  $eid=$_GET['editid'];
$sql="SELECT tbluser.FirstName,tbluser.MobileNumber,tblapplication.ID, tblapplication.ApplicationNumber, tblapplication.PanNumber,tblapplication.PanCardCopy,tblapplication.Address,tblapplication.AddressProofType,tblapplication.AdressDoc,tblapplication.ServiceType,tblapplication.MontlyIncome,tblapplication.ExistingLoan,tblapplication.ExpectedLoanAmount,tblapplication.ProfilePic,tblapplication.Tenure,tblapplication.SubmitDate,tblapplication.Remark,tblapplication.UpdationDate,tblapplication.Status,tblapplication.GName,tblapplication.Gmobnum,tblapplication.Gemail,tblapplication.Gaddress,tblapplication.DTenure,tblapplication.LoanamountDisbursed,tblapplication.RateofInterest,tblapplication.LoanamountDisbursed from  tblapplication join tbluser on tbluser.ID= tblapplication.UserID where tblapplication.ID=:eid";
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
                      <tr><th colspan="6"><img src="../images/<?php echo $row->ProfilePic;?>" width="200" height="200"></th></tr>
                      <tr>
    <th colspan="6" style="color: orange;font-weight: bold;font-size: 20px;text-align: center;">Application Number: <?php  echo $applicationno=($row->ApplicationNumber);?></th>
  </tr>
  <tr>
    <th>Full Name</th>
    <td><?php  echo $row->FirstName;?></td>
     <th>Mobile Number</th>
    <td><?php  echo $row->MobileNumber;?></td>
   <th>Service Type</th>
    <td><?php  echo $row->ServiceType;?></td>
  </tr>
   <tr>

    <th>ID Number</th>
    <td><?php  echo $row->PanNumber;?></td>
    <th>Copy of ID</th>
    <td style="text-align: center;" colspan="3"><a href="../pancardfile/<?php echo $row->PanCardCopy;?>"  width="100" height="100" target="_blank"> <strong style="color: red">View Copy of ID</strong></a></td>
  </tr>
  
  <tr>
        <th>Address</th>
    <td><?php  echo $row->Address;?></td>
    <th>Address Proof Doc</th>
   <td  style="text-align: center;"><a href="../addfile/<?php echo $row->AdressDoc;?>"  width="100" height="100" target="_blank"> <strong style="color: red">View Address Proof Document</strong></a></td>
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
    
    <th>Expected Tenure</th>
    <td><?php  echo $row->Tenure;?></td>
    <th>Date of Application</th>
    <td><?php  echo $row->SubmitDate;?></td>
     <th>Disbursed Loan Amount</th>
    <td><?php  echo $row->LoanamountDisbursed;?></td>
  </tr>
  <tr>


  <tr>
    
   
    <th> Final Status</th>
   <td> <?php  $status=$row->Status;
    
if($row->Status=="Approved")
{
  echo "Your request has been approved";
}

if($row->Status=="Rejected")
{
 echo "Your request has been rejected";
}


if($row->Status=="")
{
  echo "Not Response Yet";
}


     ;?></td>
    <th>Admin Remark</th>
    <?php if($row->Status==""){ ?>
<td  colspan="4"><?php echo "Not Updated Yet"; ?></td>
<?php } else { ?>                  
  <td colspan="4"><?php  echo htmlentities($row->Remark);?>
                  </td>
                  <?php } ?>  

  </tr>


<tr>
    <th colspan="6" style="color: orange;font-weight: bold;font-size: 20px;text-align: center;">Next of Kin Info</th>
      </tr>
   <tr>
    <th>Next of Kin Name</th>
    <td><?php  echo $row->GName;?></td>
    <th>Next of Kin Mobile Number</th>
   <td colspan="4"><?php  echo $row->Gmobnum;?></td></tr>
    <tr>
    <th>Next of Kin Email</th>
  <td><?php  echo $row->Gemail;?></td>
  <th>Next of Kin Address</th>
  <td colspan="4"><?php  echo $row->Gaddress;?></td></tr>
  </table>
  <table class="table table-bordered">
<tr>
    <th colspan="6" style="color: orange;font-weight: bold;font-size: 20px;text-align: center;">Released Amount Info</th>
      </tr>
<?php if($row->Status=="Disbursed"){ ?>

<tr>
    <th>Amount of Loan Disbursed</th>

    <td><?php  echo $dloan=$row->LoanamountDisbursed;?></td>

      <th>Date of Dibursement</th>
    <td><?php  echo $row->UpdationDate;?></td></tr>

    <tr>
    <th>Disbursement Tenure</th>
    <td><?php  echo $ltenure=$row->DTenure;?> days</td>
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
          
          <?php 

if ($status=="Approved"){
?> 
<p align="center"  style="padding-top: 20px">                            
 <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal">Take Action</button></p>  

<?php } ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
     <div class="modal-content">
      <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Take Action</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <table class="table table-bordered table-hover data-tables">
                                <form method="post" name="submit">
     <tr>
    <th>Loan Amt Disbursed :</th>
    <td>
    <input name="lmd" placeholder="Loan Amount Disbursed"  class="form-control wd-450" required="true"></td>
  </tr> 
  <tr>
    <th>Rate of Interest :</th>
    <td>
    <input name="roi" placeholder="Rate of Interest"  class="form-control wd-450" required="true"></td>
  </tr>
  <tr>
    <th>Tenure :</th>
    <td>
    <input name="tenure" placeholder="Tenure"  class="form-control wd-450" required="true"></td>
  </tr>
  <tr>
    <th>Remark :</th>
    <td>
    <textarea name="remark" placeholder="Remark" rows="12" cols="14" class="form-control wd-450" required="true"></textarea></td>
  </tr> 
</table>
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 <button type="submit" name="submit" class="btn btn-primary">Update</button>
  </form>
</div>
</div>
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
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>
<?php }  ?>