<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['hlmsuid'] == 0)) {
    header('location:logout.php');
} else {
    $uid = $_SESSION['hlmsuid'];

    // Fetching user details
    $sql = "SELECT * FROM tbluser WHERE ID=:uid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uid', $uid, PDO::PARAM_STR);
    $query->execute();
    $userDetails = $query->fetch(PDO::FETCH_OBJ);

    // Fetching loan application data
    $sqlLoans = "SELECT COUNT(*) as TotalLoans, SUM(LoanamountDisbursed) as TotalDisbursed, SUM(ExpectedLoanAmount) as AmountOwed FROM tblapplication WHERE UserID=:uid";
    $queryLoans = $dbh->prepare($sqlLoans);
    $queryLoans->bindParam(':uid', $uid, PDO::PARAM_STR);
    $queryLoans->execute();
    $loanDetails = $queryLoans->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE HTML>
<html lang="zxx">

<head>
    <title>Home Loan Management System || User Profile</title>

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
    <style>
  /* Loan Progress Bar Container */
.progress-bar-container {
    padding: 20px;
    background-color: #f8f8f8 !important;
    border-radius: 10px;
    max-width: 700px;
    margin: 0 auto;
    position: relative;
    font-family: Arial, sans-serif !important;
}

/* Vertical Line for Progress */
.progress-bar-container::before {
    content: '';
    position: absolute;
    top: 50px;
    left: 28px;
    width: 4px;
    height: 80%;
    background-color: #ddd;
    z-index: 1;
}

/* Step Style */
.step {
    display: flex;
    align-items: center;
    position: relative;
    padding-left: 40px;
    margin-bottom: 30px;
    color: #555;
}

.step:last-child {
    margin-bottom: 0;
}

/* Circle for each Step */
.step .circle {
    position: absolute;
    left: 0;
    top: 0;
    width: 30px;
    height: 30px;
    background-color: #ddd;
    border-radius: 50%;
    z-index: 2;
    text-align: center;
    line-height: 30px;
    color: white;
    font-weight: bold;
}

.step.completed .circle {
    background-color: #28a745 !important;
    content: "\2713"; /* Checkmark */
}

.step.pending .circle {
    background-color: #ddd !important;
}

/* Step Label */
.step .label {
    font-size: 16px !important;
    font-weight: bold !important;
    margin-left: 20px;
    color: #333 !important;
}

/* Completed Step */
.step.completed .label {
    color: #28a745 !important;
}

/* Animation for Completed Steps */
.step.completed .circle {
    animation: popIn 0.5s ease-in-out;
}

@keyframes popIn {
    0% {
        transform: scale(0.5);
        opacity: 0.5;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

        
    </style>
</head>

<body>

    <?php include_once('includes/header.php'); ?>

    <!-- banner -->
    <section class="banner-1"></section>
    <!-- //banner -->

    <!-- Profile Info Section -->
    <section class="typo py-5">
        <div class="container py-md-4 mt-md-3">
            <div class="grid_3 grid_5 w3l">
                <h3>User Profile</h3>
                <div class="alert alert-success" role="alert">
                    <strong>Welcome, <?php echo htmlentities($userDetails->FirstName); ?>!</strong> Here are your profile details.
                </div>
            </div>

            <!-- User Info -->
            <div class="row">
                <div class="col-md-4">
                    <h4>Personal Information</h4>
                    <p><strong>First Name: </strong><?php echo htmlentities($userDetails->FirstName); ?></p>
                    <p><strong>Last Name: </strong><?php echo htmlentities($userDetails->LastName); ?></p>
                    <p><strong>Mobile Number: </strong><?php echo htmlentities($userDetails->MobileNumber); ?></p>
                    <p><strong>Email: </strong><?php echo htmlentities($userDetails->Email); ?></p>
                    <p><strong>ID Number: </strong><?php echo htmlentities($userDetails->Aadhaar); ?></p>
                    
                </div>

                <!-- Loan Tiles -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">Total Loans</div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlentities($loanDetails->TotalLoans); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                                <div class="card-header">Total Loan Disbursed</div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlentities($loanDetails->TotalDisbursed); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                                <div class="card-header">Amount Owed</div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlentities($loanDetails->AmountOwed); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<hr class="bs-docs-separator">
  <!-- Downloadable Documents Section -->
                    <h4>Documents</h4>
                    <p><a href="documents/loan_agreement.pdf" download>Download Loan Agreement</a></p>
                    <p><a href="documents/client_affordability.pdf" download>Download Client Affordability</a></p>
                    <p><a href="authority_mandate.pdf">Download Authority and Mandate for Payment</a></p>
                    <p><a href="documents/client_statement.pdf" download>Download Client Statement</a></p>
                    <p><a href="electronic-signatures.php">Download Agreement to Use Electronic Signatures</a></p>
<!-- Application History Section (existing) -->
<hr class="bs-docs-separator">
<div class="grid_3 grid_5 w3l">
    <h3>Loan Application History</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Application Number</th>
                <th>ID Number</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT ApplicationNumber, PanNumber, Status FROM tblapplication WHERE UserID=:uid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':uid', $uid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            $cnt = 1;
            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
            ?>
                    <tr>
                        <td><?php echo htmlentities($cnt); ?></td>
                        <td><?php echo htmlentities($row->ApplicationNumber); ?></td>
                        <td><?php echo htmlentities($row->PanNumber); ?></td>
                        <td><?php echo htmlentities($row->Status); ?></td>
                    </tr>

            <?php
                    $cnt++;
                }
            }
            ?>
        </tbody>
    </table>
    
                    <!-- Add Progress Bar for Loan Status Below Each Record -->
                   <div class="progress-bar-container">
    <!-- Loan Agreement Signed -->
    <div class="step completed">
        <div class="circle">✔</div>
        <div class="label">Loan agreement signed</div>
    </div>

    <!-- Income & Bank Verified -->
    <div class="step pending">
        <div class="circle">2</div>
        <div class="label">Income & bank verified</div>
    </div>

    <!-- DebiCheck Mandate Request Sent -->
    <div class="step pending">
        <div class="circle">3</div>
        <div class="label">DebiCheck mandate request sent</div>
    </div>

    <!-- DebiCheck Mandate Approved -->
    <div class="step pending">
        <div class="circle">4</div>
        <div class="label">DebiCheck mandate approved</div>
    </div>

    <!-- Cash is on its Way -->
    <div class="step pending">
        <div class="circle">5</div>
        <div class="label">Cash is on its way</div>
    </div>
</div>

</div>

            
        </div>
    </section>
    <!-- //Profile Info Section -->

    <?php include_once('includes/footer.php'); ?>

    <!-- js-->
    <script src="js/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"></script>
</body>

</html>

<?php
}
?>
