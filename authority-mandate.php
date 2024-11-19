<?php
// Database connection (make sure you have the correct credentials)
include('includes/dbconnection.php');
session_start();
error_reporting(1);

// Assume user ID is stored in session
$user_id = $_SESSION['hlmsuid'];

// Fetch user details from tbluser
$query = "SELECT FirstName, LastName, Aadhaar, Address FROM tbluser WHERE id = :user_id";
$stmt = $dbh->prepare($query);
$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Sample branch and other details
$branch_registered_name = "Enterwise Finance";
$branch_name = "Pretoria";
$approved_by = "Enterwise Loan Officer";  // Example value
$signed_at = "Pretoria";
$date_today = date("F j, Y");

?>


<!DOCTYPE HTML>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <title>Agreement to Use Electronic Signatures</title>
    
    <!-- Include Bootstrap and other CSS files -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
     <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            
            background-color: #f9f9f9;
        }
        .document {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            font-size: 1.5em;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        p {
            font-size: 0.9em;
            line-height: 1.6;
            color: #555;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        table tr:last-child td {
            border-bottom: none;
        }
        .signature-line {
            margin-top: 20px;
            text-align: left;
            font-size: 0.9em;
            color: #333;
        }
        .btn-download {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }
        .btn-download:hover {
            background-color: #0056b3;
        }
         
         .title {
            font-weight: bold;
            font-size: 10.0pt;
            color: black;
            margin-bottom: 10px;
        }
        .sub-title {
            font-weight: bold;
            font-size: 9.0pt;
            color: black;
        }
        .field-value {
            font-size: 9.0pt;
            color: black;
        }
        .signature-line {
            margin-top: 20px;
            font-size: 9.0pt;
            color: black;
        }
         
    </style>
</head>

<body>
    <?php include_once('includes/header.php'); ?>
    
    <div class="document" id="document">
    <h1>AUTHORITY AND MANDATE FOR PAYMENT INSTRUCTIONS:</h1>

    <p><strong>A. AUTHORITY:</strong></p>
        <p class="sub-title">GIVEN BY: <?= htmlspecialchars($user['FirstName']); ?> <?= htmlspecialchars($user['LastName']); ?>:</p>
    <p class="field-value">[CLIENT.BANKACCHOLDER]</p>
    <p>Address: <?= htmlspecialchars($user['Address']); ?> </p>
        
     <p class="sub-title"><strong>BANK ACCOUNT DETAILS:</strong></p>
    <p><strong>BANK NAME:</strong> <span class="field-value">[CLIENT.BANKNAME]</span></p>
    <p><strong>BRANCH NAME AND TOWN:</strong> <span class="field-value">[CLIENT.BANKBRANCH]</span></p>
    <p><strong>BRANCH NUMBER:</strong> <span class="field-value">[Bank.BANKBRANCH]</span></p>
    <p><strong>ACCOUNT NUMBER:</strong> <span class="field-value">[CLIENT.BANKACCNR]</span></p>
    <p><strong>TYPE OF ACCOUNT:</strong> <span class="field-value">[Client.LU_BANKACCTYPE_DESC]</span></p>
    <p><strong>DATE:</strong> <span class="field-value">[Loan.TDATE]</span></p>
    
    <p><strong>TO:</strong> <span class="field-value">[CLIENT.BRANCHNAME]</span></p>

        
         <p class="field-value">
        Abbreviated Short Name as registered with the Acquiring bank:<br>
        ___________________________________________
    </p>
        <p class="sub-title"><strong>REFER TO OUR CONTRACT DATED</strong> [Loan.TDATE] (“the Agreement”)</p>
    
        
    <p>I/We hereby authorise[BRANCH.BRANCH_NAME]to issue and deliver payment instructions to your banker for collection against my/our abovementioned account at my/our abovementioned bank.
<p>The individual payment instructions so authorised to be issued, must be issued and delivered [Loan.LOANPERIOD] (interval) on the date when the obligation in terms of the Agreement is due and the amount of each individual payment instruction may not differ as agreed to in terms of the Agreement.</p>
<p>The payment instructions so authorised to be issued, must carry a number, which number must be included in the said payment instructions and if provided to you should enable you to identify the Agreement on your bank statement. The said number should be added to this form in section E before the issuing of any payment instruction and communicated to me directly after having been completed by you.</p>
<p>I/we agree that the first payment instruction will be issued and delivered on [Loan.FDATE] (date) and thereafter regularly according to the agreement, * except for payment instructions due in December which may be debited against my account prior.</p>
        
<p>If however, the date of the payment instruction falls on a non-processing day (weekend or public holiday) I agree that the payment instruction may be debited against my account on the following business day; or The date of the instruction falls on a non-processing day (weekend or public holiday) I agree that the payment instruction may be debited against my account on the business day prior to the non-processing day.</p>
<p>To allow for tracking of dates to match with flow of Credit at no additional cost to myself.
I authorise the originator to make use of the tracking facility as provided for in the EDO system at no additional cost to myself.</p>
<p>Subsequent payment instructions will continue to be delivered in terms of this authority until the obligations in terms of the Agreement have been paid or until this authority is cancelled by me/us by giving you notice in writing of not less than the interval (as indicated in the previous clause) and sent by prepaid registered post or delivered to your address indicated above.</p>
         <p><strong>B. MANDATE</strong></p>
        
     <p>I/we acknowledge that all payment instructions issued by you shall be treated by my/our abovementioned bank as if the instructions had been issued by me/us personally.</p>
        <p><strong>C. CANCELLATION</strong></p>

<p>I/we agree that although this authority and mandate may be cancelled by me/us, such cancellation will not cancel the Agreement. I/we also understand that I/we cannot reclaim amounts, which have been withdrawn from my/our account (paid) in terms of this authority and mandate if such amounts were legally owing to you.</p>
         <p><strong>D. ASSIGNMENT:</strong></p>

<p>I/We acknowledge that this authority may be ceded or assigned to a third party if the Agreement is also ceded or assigned to that third party.</p>

    <p class="signature-line">SIGNED at <?= $signed_at; ?> on <?= $date_today; ?></p>
        
      <p class="signature-line">
        [SIGNATURES.SIG_BORROWER]
          <br>--------------------------------------
        <br>Signature as used for operating on the account
    </p>
    
    <p class="signature-line">
        [SIGNATURES.SIG_LENDER]
        <br>----------------------------------------
        <br>Signature as used for operating on the account
    </p>
        
        
        <p><strong>E. CONTRACT / AGREEMENT REFERENCE NUMBER</strong></p>
        
        <table class="Table" style="border-collapse: collapse; width: 692px;" cellspacing="0">
  <tbody>
    <tr>
      <td style="width: 260.65pt; text-align: justify;">
        [SIGNATURES.SIG_BORROWER]<br /><br />
        <span style="font-size: 9.0pt; font-family: 'Arial', sans-serif; color: black;">
          _______________________________
        </span>
      </td>
      <td style="width: 258.65pt; text-align: justify;">
        [SIGNATURES.SIG_WITNESS_1]<br /><br />
        <span style="font-size: 9.0pt; font-family: 'Arial', sans-serif; color: black;">
          _______________________________
        </span>
      </td>
    </tr>
    <tr>
      <td style="width: 260.65pt; text-align: justify;">
        <span style="font-size: 9.0pt; font-family: 'Arial', sans-serif; color: black;">
          BORROWER
        </span>
      </td>
      <td style="width: 258.65pt; text-align: justify;">
        <span style="font-size: 9.0pt; font-family: 'Arial', sans-serif; color: black;">
          WITNESS
        </span>
      </td>
    </tr>
    <tr>
      <td style="width: 260.65pt; text-align: justify;">
        <br />
        <span style="font-size: 9.0pt; font-family: 'Arial', sans-serif; color: black;">
          CONDITIONS ACCEPTED BY LENDER<br />Alberton
        </span>
        <br />&nbsp;
      </td>
      <td style="width: 258.65pt; text-align: justify;">
        <br /><br /><br />&nbsp;
      </td>
    </tr>
    <tr>
      <td style="width: 260.65pt; text-align: justify;">
        &nbsp;
      </td>
      <td style="width: 258.65pt; text-align: justify;">
        &nbsp;
      </td>
    </tr>
  </tbody>
</table>

        

   
</div>

<!-- Button to Download PDF -->
<button class="btn-download" onclick="downloadPDF()">Download as PDF</button>

<!-- JS Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    function downloadPDF() {
        var element = document.getElementById('document');
        html2pdf(element, {
            margin: 1,
            filename: 'AUTHORITY_AND_MANDATE_FOR_PAYMENT_INSTRUCTIONS.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        });
    }
</script>

    <?php include_once('includes/footer.php'); ?>

    <!-- Include JavaScript files -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>
