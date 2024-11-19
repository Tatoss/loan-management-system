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
    </style>
</head>

<body>
    <?php include_once('includes/header.php'); ?>
    
    <div class="document" id="document">
    <h1>AGREEMENT TO USE ELECTRONIC SIGNATURES</h1>

    <p><strong>1. PARTIES</strong></p>
    <p>1.1 <?= htmlspecialchars($branch_registered_name); ?> t/a <?= htmlspecialchars($branch_name); ?> ("the Credit Provider"); and</p>
    <p>1.2 <?= htmlspecialchars($user['FirstName']); ?> <?= htmlspecialchars($user['LastName']); ?> ("the Consumer")</p>

    <p><strong>2. USE OF ELECTRONIC SIGNATURES</strong></p>
    <p>1.3 The Credit Provider and the Consumer ("the Parties") wish to conclude agreements with each other...</p>
     <p>1.4 The Parties hereby agree that for purposes of the conclusion of any agreement between the Parties or the completion of any documentation, the requirements for signature of such agreement and/or documentation shall be met if a Party or its representative signs the agreement or document by way of an electronic signature using a Topaz electronic signature pad. Such electronic signature shall be stored in the Delfin system.</p>

<p>1.5 The Parties record that for each agreement or document that needs to be signed, a copy of an electronic signature that was recorded previously may not be used and it shall be necessary to apply a fresh electronic signature using a Topaz electronic signature pad.</p>

<p>1.6 The Parties agree that any agreement or document which has been signed by or on behalf of a Party by way of an electronic signature as set out above shall be regarded as validly signed for purposes of any legal proceedings. A printed copy of the electronic agreement or document, containing such electronic signature(s), shall be sufficient proof of such agreement or document. The Parties agree not to challenge the validity of any document or agreement which they have signed using an electronic signature as set out above.</p>

    <p class="signature-line">SIGNED at <?= $signed_at; ?> on <?= $date_today; ?></p>

    <table>
        <tr>
            <td>________________________________</td>
            <td>_________________________</td>
        </tr>
        <tr>
            <td>CONSUMER</td>
            <td>CREDIT PROVIDER</td>
        </tr>
        <tr>
            <td>Full names: <?= htmlspecialchars($user['FirstName']); ?> <?= htmlspecialchars($user['LastName']); ?></td>
            <td>Name of signatory: <?= htmlspecialchars($approved_by); ?></td>
        </tr>
        <tr>
            <td>As witness: _________________________</td>
            <td>As witness: _________________________</td>
        </tr>
        <tr>
            <td>ID No: <?= htmlspecialchars($user['Aadhaar']); ?></td>
            <td>ID NO: 1234567898973</td>
        </tr>
        <tr>
            <td>Address: <?= htmlspecialchars($user['Address']); ?></td>
            <td>Address: Pretoria</td>
        </tr>
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
            filename: 'Agreement_to_Use_Electronic_Signatures.pdf',
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
