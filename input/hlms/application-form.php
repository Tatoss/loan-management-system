<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if user is logged in
if (strlen($_SESSION['hlmsuid']) == 0) {
    header('Location: logout.php');
    exit();
}

if(isset($_POST['submit'])) {
    try {
        // Sanitize and assign POST data
        $uid = $_SESSION['hlmsuid'];
        $pannum = htmlspecialchars(trim($_POST['pannum']));
        $address = htmlspecialchars(trim($_POST['address']));
        $addtypeproof = htmlspecialchars(trim($_POST['addressproofdoc']));
        $sertype = htmlspecialchars(trim($_POST['sertype']));
        $mincome = htmlspecialchars(trim($_POST['monthlyincome']));
        $exloan = htmlspecialchars(trim($_POST['exloan']));
        $explamt = htmlspecialchars(trim($_POST['explamt']));
        $tenure = htmlspecialchars(trim($_POST['tenure']));
        $gname = htmlspecialchars(trim($_POST['gname']));
        $gmobnum = htmlspecialchars(trim($_POST['gmobnum']));
        $gemail = htmlspecialchars(trim($_POST['gemail']));
        $gaddress = htmlspecialchars(trim($_POST['gaddress']));
        $employerName = htmlspecialchars(trim($_POST['employername']));
        $employerNumber = htmlspecialchars(trim($_POST['employernumber']));
        $dateStartedWorking = htmlspecialchars(trim($_POST['datestartedworking']));
        $nextPayday = htmlspecialchars(trim($_POST['nextpayday']));
        $preferredDebitOrderDate = htmlspecialchars(trim($_POST['preferreddebitorderdate']));

        // Handle file uploads
        $uploads_dir = [
            'pccopy' => 'pancardfile/',
            'uaddproof' => 'addfile/',
            'profile' => 'images/',
            'latestpayslip' => 'payslips/',
            'bankstatement' => 'bankstatements/'
        ];

        // Allowed file extensions
        $allowed_extensions_docs = ['doc', 'docs', 'pdf'];
        $allowed_extensions_images = ['jpg', 'jpeg', 'png', 'gif'];

        // Function to handle file uploads
        function handleFileUpload($fileInputName, $allowed_extensions, $destination_dir) {
            if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] != UPLOAD_ERR_OK) {
                throw new Exception("Error uploading file: " . $fileInputName);
            }

            $file_tmp = $_FILES[$fileInputName]['tmp_name'];
            $file_name = $_FILES[$fileInputName]['name'];
            $file_size = $_FILES[$fileInputName]['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (!in_array($file_ext, $allowed_extensions)) {
                throw new Exception("Invalid file format for " . $fileInputName . ". Allowed formats: " . implode(', ', $allowed_extensions));
            }

            // Generate a unique file name
            $new_filename = md5($file_name . time()) . "." . $file_ext;

            // Ensure the destination directory exists
            if (!is_dir($destination_dir)) {
                mkdir($destination_dir, 0755, true);
            }

            // Move the uploaded file
            if (!move_uploaded_file($file_tmp, $destination_dir . $new_filename)) {
                throw new Exception("Failed to move uploaded file: " . $fileInputName);
            }

            return $new_filename;
        }

        // Upload files
        $pccopy = handleFileUpload('pccopy', $allowed_extensions_docs, $uploads_dir['pccopy']);
        $uaddproof = handleFileUpload('uaddproof', $allowed_extensions_docs, $uploads_dir['uaddproof']);
        $profile = handleFileUpload('profile', $allowed_extensions_images, $uploads_dir['profile']);
        $latestpayslip = handleFileUpload('latestpayslip', $allowed_extensions_docs, $uploads_dir['latestpayslip']);
        $bankstatement = handleFileUpload('bankstatement', $allowed_extensions_docs, $uploads_dir['bankstatement']);

        // Generate a unique application number
        $applicationno = mt_rand(10000, 99999);

        // Insert data into the database
        $sql = "INSERT INTO tblapplication 
                (UserID, ApplicationNumber, PanNumber, PanCardCopy, Address, AddressProofType, AdressDoc, ServiceType, MontlyIncome, ExistingLoan, ExpectedLoanAmount, ProfilePic, Tenure, GName, Gmobnum, Gemail, Gaddress, LatestPayslip, bankstatement, NextPayday, PreferredDebitOrderDate, EmployerName, EmployerNumber, DateStartedWorking) 
                VALUES 
                (:uid, :applicationno, :pannum, :pccopy, :address, :addtypeproof, :uaddproof, :sertype, :mincome, :exloan, :explamt, :profile, :tenure, :gname, :gmobnum, :gemail, :gaddress, :latestpayslip, :bankstatement, :nextpayday, :preferreddebitorderdate, :employername, :employernumber, :datestartedworking)";

        $query = $dbh->prepare($sql);
        $query->bindParam(':uid', $uid, PDO::PARAM_INT);
        $query->bindParam(':applicationno', $applicationno, PDO::PARAM_INT);
        $query->bindParam(':pannum', $pannum, PDO::PARAM_STR);
        $query->bindParam(':pccopy', $pccopy, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':addtypeproof', $addtypeproof, PDO::PARAM_STR);
        $query->bindParam(':uaddproof', $uaddproof, PDO::PARAM_STR);
        $query->bindParam(':sertype', $sertype, PDO::PARAM_STR);
        $query->bindParam(':mincome', $mincome, PDO::PARAM_STR);
        $query->bindParam(':exloan', $exloan, PDO::PARAM_STR);
        $query->bindParam(':explamt', $explamt, PDO::PARAM_STR);
        $query->bindParam(':profile', $profile, PDO::PARAM_STR);
        $query->bindParam(':tenure', $tenure, PDO::PARAM_INT);
        $query->bindParam(':gname', $gname, PDO::PARAM_STR);
        $query->bindParam(':gmobnum', $gmobnum, PDO::PARAM_STR);
        $query->bindParam(':gemail', $gemail, PDO::PARAM_STR);
        $query->bindParam(':gaddress', $gaddress, PDO::PARAM_STR);
        $query->bindParam(':latestpayslip', $latestpayslip, PDO::PARAM_STR);
        $query->bindParam(':bankstatement', $bankstatement, PDO::PARAM_STR);
        $query->bindParam(':nextpayday', $nextPayday, PDO::PARAM_STR);
        $query->bindParam(':preferreddebitorderdate', $preferredDebitOrderDate, PDO::PARAM_STR);
        $query->bindParam(':employername', $employerName, PDO::PARAM_STR);
        $query->bindParam(':employernumber', $employerNumber, PDO::PARAM_STR);
        $query->bindParam(':datestartedworking', $dateStartedWorking, PDO::PARAM_STR);

        $query->execute();

        $LastInsertId = $dbh->lastInsertId();
        if ($LastInsertId > 0) {
            echo '<script>alert("Your Application Has been sent.")</script>';
            echo "<script>window.location.href ='application-history.php'</script>";
            exit();
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }

    } catch (Exception $e) {
        echo '<script>alert("Error: ' . $e->getMessage() . '")</script>';
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Home Loan Management System::Application Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />

    <style>
        /* Custom Styles for the Form */
        .application-form {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .application-form h2 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #333;
        }
        .application-form label {
            font-weight: 600;
            color: #555;
        }
        .application-form .form-control:focus {
            border-color: #0d6efd;
            box-shadow: none;
        }
        .application-form .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .application-form .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        .application-form .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .application-form .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>

<body>
    <?php include_once('includes/header.php'); ?>
    
    <!-- Banner -->
    <section class="banner-1">
        <!-- You can add banner content here -->
    </section>
    <!-- //Banner -->

    <!-- Application Form Section -->
    <section class="contact py-5">
        <div class="container py-md-4 mt-md-3">
            <h2 class="heading-agileinfo">Application Form<span>Fill the following details</span></h2>
            <div class="inner-sec-w3layouts-agileinfo mt-md-5 pt-5">
                <div class="contact_grid_right mt-5">
                    <h6>Please Fill the Following Details</h6>
                    <div class="application-form">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <?php
                                $uid = $_SESSION['hlmsuid'];
                                $sql = "SELECT * FROM tbluser WHERE ID = :uid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':uid', $uid, PDO::PARAM_INT);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0) {
                                    foreach($results as $row) {               
                                ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name:</label>	
                                        <input value="<?php echo htmlspecialchars($row->FirstName); ?>" name="fname" type="text" class="form-control" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Mobile Number:</label>	
                                        <input type="text" class="form-control" name="mobno" maxlength="10" pattern="[0-9]{10}" value="<?php echo htmlspecialchars($row->MobileNumber); ?>" readonly required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Id Number:</label>
                                    <input type="text" value="<?php echo htmlspecialchars($row->Aadhaar); ?>" name="pannum" class="form-control" readonly required />
                                </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label>Upload ID COPY:</label>
                                <input type="file" name="pccopy" class="form-control-file" accept=".doc,.docs,.pdf" required>
                            </div>
                            <div class="form-group">
                                <label>Profile Photo:</label>
                                <input type="file" name="profile" class="form-control-file" accept=".jpg,.jpeg,.png,.gif" required>
                            </div>

                            <div class="form-group">
                                <label>Address:</label>
                                <textarea class="form-control" name="address" rows="3" required></textarea>
                            </div>

                            <div class="form-group">
                                <label>Proof of Address Type:</label>
                                <select class="form-control" name="addressproofdoc" required>
                                    <option value="">Choose</option>
                                    <option value="bank statement">Bank Statement</option>
                                    <option value="Municipal">Municipal Letter</option>
                                    <option value="Other">Other (Any Other)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Upload Proof of Address:</label>
                                <input type="file" name="uaddproof" class="form-control-file" accept=".doc,.docs,.pdf" required>
                            </div>

                            <div class="form-group">
                                <label>Employment Type (Govt/Private/Self Employed):</label>
                                <input type="text" name="sertype" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Monthly Income:</label>
                                <input type="number" name="monthlyincome" class="form-control" min="0" required>
                            </div>

                            <div class="form-group">
                                <label>Existing Loan:</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="exloan" id="loanYes" value="Yes" required>
                                    <label class="form-check-label" for="loanYes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="exloan" id="loanNo" value="No" required>
                                    <label class="form-check-label" for="loanNo">No</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Expected Loan Amount:</label>
                                <input type="number" name="explamt" class="form-control" min="0" required>
                            </div>

                            <div class="form-group">
                                <label>Tenure (in months):</label>
                                <select name="tenure" class="form-control" required>
                                    <option value="">Choose</option>
                                    <option value="30">30 days</option>
                                    <option value="60">60 days</option>
                                    <option value="90">90 days</option>
                                </select>
                            </div>


                            <hr>

                            <h4>Next of Kin</h4>
                            <div class="form-group">
                                <label>Next of Kin Name:</label>
                                <input type="text" name="gname" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Next of Kin Mobile Number:</label>
                                <input type="text" name="gmobnum" class="form-control" pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number" required>
                            </div>

                            <div class="form-group">
                                <label>Next of Kin Email:</label>
                                <input type="email" name="gemail" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Next of Kin Address:</label>
                                <textarea class="form-control" name="gaddress" rows="3" required></textarea>
                            </div>

                            <hr>

                            <h4>Employment Information</h4>
                            <div class="form-group">
                                <label>Employer Name:</label>
                                <input type="text" name="employername" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Employer Number:</label>
                                <input type="text" name="employernumber" class="form-control" pattern="[0-9]{10}" title="Enter a valid 10-digit employer number" required>
                            </div>

                            <div class="form-group">
                                <label>Date Started Working:</label>
                                <input type="date" name="datestartedworking" class="form-control" required>
                            </div>

                            <hr>

                            <h4>Financial Information</h4>
                            <div class="form-group">
                                <label>Latest Payslip:</label>
                                <input type="file" name="latestpayslip" class="form-control-file" accept=".doc,.docs,.pdf" required>
                            </div>

                            <div class="form-group">
                                <label>Bank Statement:</label>
                                <input type="file" name="bankstatement" class="form-control-file" accept=".doc,.docs,.pdf" required>
                            </div>

                            <div class="form-group">
                                <label>Next Payday:</label>
                                <input type="date" name="nextpayday" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Preferred Debit Order Date:</label>
                                <input type="date" name="preferreddebitorderdate" class="form-control" required>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                                <button type="reset" class="btn btn-secondary">Clear</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--//Application Form-->

    <?php include_once('includes/footer.php'); ?>

    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
