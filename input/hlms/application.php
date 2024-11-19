<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['hlmsuid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        try {
            $uid = $_SESSION['hlmsuid'];
            $pannum = $_POST['pannum'];
            $address = $_POST['address'];
            $addtypeproof = $_POST['addressproofdoc'];
            $sertype = $_POST['sertype'];
            $mincome = $_POST['monthlyincome'];
            $exloan = $_POST['exloan'];
            $explamt = $_POST['explamt'];
            $tenure = $_POST['tenure'];
            $gname = $_POST['gname'];
            $gmobnum = $_POST['gmobnum'];
            $gemail = $_POST['gemail'];
            $gaddress = $_POST['gaddress'];
            $nextPayday = $_POST['nextpayday'];
            $preferredDebitOrderDate = $_POST['preferreddebitorderdate'];
            $employerName = $_POST['employername'];
            $employerNumber = $_POST['employernumber'];
            $dateStartedWorking = $_POST['datestartedworking'];
            
            $file = $_FILES["pccopy"]["name"];
            $file1 = $_FILES["uaddproof"]["name"];
            $image = $_FILES["profile"]["name"];
            $payslip = $_FILES["latestpayslip"]["name"];
            $applicationno = mt_rand(10000, 99999);

            // File validation and upload
            $allowed_extensions = array(".docs", ".doc", ".pdf");
            $allowed_extensions2 = array(".jpg", ".jpeg", ".png", ".gif");

            // Validate PanCard Copy
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (!in_array("." . $extension, $allowed_extensions)) {
                throw new Exception('Invalid PanCard file format. Only docs/doc/pdf allowed.');
            }
            $file = md5($file) . time() . "." . $extension;
            move_uploaded_file($_FILES["pccopy"]["tmp_name"], "pancardfile/" . $file);

            // Validate Address Proof
            $extension1 = strtolower(pathinfo($file1, PATHINFO_EXTENSION));
            if (!in_array("." . $extension1, $allowed_extensions)) {
                throw new Exception('Invalid Address Proof file format. Only docs/doc/pdf allowed.');
            }
            $file1 = md5($file1) . time() . "." . $extension1;
            move_uploaded_file($_FILES["uaddproof"]["tmp_name"], "addfile/" . $file1);

            // Validate Profile Picture
            $extension2 = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            if (!in_array("." . $extension2, $allowed_extensions2)) {
                throw new Exception('Invalid Profile Picture format. Only jpg/jpeg/png/gif allowed.');
            }
            $image = md5($image) . time() . "." . $extension2;
            move_uploaded_file($_FILES["profile"]["tmp_name"], "images/" . $image);

            // Validate Payslip
            $extension3 = strtolower(pathinfo($payslip, PATHINFO_EXTENSION));
            if (!in_array("." . $extension3, $allowed_extensions)) {
                throw new Exception('Invalid Payslip format. Only docs/doc/pdf allowed.');
            }
            $payslip = md5($payslip) . time() . "." . $extension3;
            move_uploaded_file($_FILES["latestpayslip"]["tmp_name"], "payslips/" . $payslip);

            // Insert data into database
            $sql = "INSERT INTO tblapplication 
                    (UserID, ApplicationNumber, PanNumber, PanCardCopy, Address, AddressProofType, AdressDoc, ServiceType, MontlyIncome, ExistingLoan, ExpectedLoanAmount, ProfilePic, Tenure, GName, Gmobnum, Gemail, Gaddress, LatestPayslip, NextPayday, PreferredDebitOrderDate, EmployerName, EmployerNumber, DateStartedWorking) 
                    VALUES 
                    (:uid, :applicationno, :pannum, :file, :address, :addtypeproof, :file1, :sertype, :mincome, :exloan, :explamt, :image, :tenure, :gname, :gmobnum, :gemail, :gaddress, :payslip, :nextpayday, :preferreddebitorderdate, :employername, :employernumber, :datestartedworking)";

            $query = $dbh->prepare($sql);
            $query->bindParam(':uid', $uid, PDO::PARAM_STR);
            $query->bindParam(':pannum', $pannum, PDO::PARAM_STR);
            $query->bindParam(':file', $file, PDO::PARAM_STR);
            $query->bindParam(':address', $address, PDO::PARAM_STR);
            $query->bindParam(':addtypeproof', $addtypeproof, PDO::PARAM_STR);
            $query->bindParam(':file1', $file1, PDO::PARAM_STR);
            $query->bindParam(':sertype', $sertype, PDO::PARAM_STR);
            $query->bindParam(':mincome', $mincome, PDO::PARAM_STR);
            $query->bindParam(':exloan', $exloan, PDO::PARAM_STR);
            $query->bindParam(':explamt', $explamt, PDO::PARAM_STR);
            $query->bindParam(':image', $image, PDO::PARAM_STR);
            $query->bindParam(':tenure', $tenure, PDO::PARAM_STR);
            $query->bindParam(':gname', $gname, PDO::PARAM_STR);
            $query->bindParam(':gmobnum', $gmobnum, PDO::PARAM_STR);
            $query->bindParam(':gemail', $gemail, PDO::PARAM_STR);
            $query->bindParam(':gaddress', $gaddress, PDO::PARAM_STR);
            $query->bindParam(':payslip', $payslip, PDO::PARAM_STR);
            $query->bindParam(':nextpayday', $nextPayday, PDO::PARAM_STR);
            $query->bindParam(':preferreddebitorderdate', $preferredDebitOrderDate, PDO::PARAM_STR);
            $query->bindParam(':employername', $employerName, PDO::PARAM_STR);
            $query->bindParam(':employernumber', $employerNumber, PDO::PARAM_STR);
            $query->bindParam(':datestartedworking', $dateStartedWorking, PDO::PARAM_STR);
            $query->bindParam(':applicationno', $applicationno, PDO::PARAM_STR);

            $query->execute();

            $LastInsertId = $dbh->lastInsertId();
            if ($LastInsertId > 0) {
                $_SESSION['success'] = "Your application has been successfully submitted!";
                header('Location: application-history.php');
                exit();
            } else {
                throw new Exception('Database insertion failed.');
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: application-form.php');
            exit();
        }
    }
}
?>

<!DOCTYPE HTML>
<html lang="zxx">
<head>
    
       <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Enterwise System::Loan Application Form</title>

    <!-- Bootstrap and Font Awesome CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/fontawesome-all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Hide all steps by default */
        .step { display: none; }
        .step.active { display: block; }
        .step-header { display: flex; justify-content: space-around; }
        .step-header div { text-align: center; padding: 10px; }
        .step-header .active { font-weight: bold; color: #0d6efd; }
    </style>
</head>
<body>
    <?php include_once('includes/header2.php'); ?>
    <!-- banner -->
	<section class="banner-1">
	</section>
	<!-- //banner -->
    <section class="contact py-5">
        <div class="container py-md-4 mt-md-3">
            <h2 class="heading-agileinfo">Application Form<span>Fill the following details</span></h2>
            <div class="inner-sec-w3layouts-agileinfo mt-md-5 pt-5">
                <div class="contact_grid_right mt-5">
                    <h6>Please Fill the Following Details</h6>
                   <div class="container my-4 p-3 bg-light border rounded">
        <form method="post" enctype="multipart/form-data" id="multiStepForm" action="application.php">
            <!-- Step Progress Indicator -->
            <div class="step-header mb-4">
                <div class="step-indicator" id="step-1-indicator">Step 1: User Info</div>
                <div class="step-indicator" id="step-2-indicator">Step 2: Address</div>
                <div class="step-indicator" id="step-3-indicator">Step 3: Loan Info</div>
                <div class="step-indicator" id="step-4-indicator">Step 4: Next of Kin</div>
                <div class="step-indicator" id="step-5-indicator">Step 5: Employment</div>
                <div class="step-indicator" id="step-6-indicator">Step 6: Financial</div>
            </div>

            <!-- Step 1: User Information -->
            <div class="step active" id="step-1">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5>User Information</h5>
                    </div>
                    <?php
$uid=$_SESSION['hlmsuid'];
$sql="SELECT * from  tbluser where ID=:uid";
$query = $dbh -> prepare($sql);
$query->bindParam(':uid',$uid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Name:</label>
                                <input type="text" value="<?php echo $row->FirstName; ?>" name="fname" class="form-control" readonly required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile Number:</label>
                                <input type="text" value="<?php echo $row->MobileNumber; ?>" name="mobno" class="form-control" readonly required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Profile Photo:</label>
                            <input type="file" class="form-control" name="profile" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ID Number:</label>
                            <input type="text" value="<?php echo $row->Aadhaar; ?>" name="pannum" class="form-control" readonly required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload ID Copy:</label>
                            <input type="file" name="pccopy" class="form-control" required>
                        </div>
                    </div>
                       <?php
                }
            } ?>
                </div>
            </div>

            <!-- Step 2: Address Information -->
            <div class="step" id="step-2">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5>Address Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Address:</label>
                            <textarea name="address" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Proof of Address Type:</label>
                            <select name="addressproofdoc" class="form-select" required>
                                <option value="">Choose</option>
                                <option value="bank statement">Bank statement</option>
                                <option value="Municipal">Municipal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Proof of Address:</label>
                            <input type="file" name="uaddproof" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Loan Information -->
            <div class="step" id="step-3">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5>Loan Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Employment Type:</label>
                                <input type="text" name="sertype" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Monthly Income:</label>
                                <input type="text" name="monthlyincome" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Existing Loan:</label>
                            <select name="exloan" class="form-select" required>
                                <option value="">Choose</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Expected Loan Amount:</label>
                                <input type="text" name="explamt" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tenure (in months):</label>
                                <input type="text" name="tenure" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Next of Kin Information -->
            <div class="step" id="step-4">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5>Next of Kin Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Next of Kin Name:</label>
                                <input type="text" name="gname" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Next of Kin Mobile:</label>
                                <input type="text" name="gmobnum" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Next of Kin Email:</label>
                            <input type="email" name="gemail" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Next of Kin Address:</label>
                            <textarea name="gaddress" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 5: Employment Information -->
            <div class="step" id="step-5">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5>Employment Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Employer Name:</label>
                                <input type="text" name="employername" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Employer Number:</label>
                                <input type="text" name="employernumber" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date Started Working:</label>
                            <input type="date" name="datestartedworking" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 6: Financial Information -->
            <div class="step" id="step-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5>Financial Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Latest Payslip:</label>
                            <input type="file" name="latestpayslip" class="form-control" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Next Payday:</label>
                                <input type="date" name="nextpayday" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Preferred Debit Order Date:</label>
                                <input type="date" name="preferreddebitorderdate" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" id="prevBtn" onclick="prevStep()">Previous</button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextStep()">Next</button>
            </div>
        </form>
    </div>


                </div>
            </div>
        </div>
    </section>
    
    <script>
      let currentStep = 0;
showStep(currentStep); // Display the first step

function showStep(n) {
    const steps = document.querySelectorAll('.step');
    steps.forEach((step, index) => {
        step.style.display = index === n ? 'block' : 'none';
    });

    // Update step indicators
    document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
        indicator.classList.toggle('active', index === n);
    });

    // Toggle button visibility
    document.getElementById('prevBtn').style.display = (n === 0) ? 'none' : 'inline';

    // If it's the last step, change button text to "Submit"
    document.getElementById('nextBtn').textContent = (n === steps.length - 1) ? 'Submit' : 'Next';
}

function nextStep() {
    const steps = document.querySelectorAll('.step');
    
    // Validate current step before moving to the next step
    if (!validateStep(currentStep)) {
        alert("Please fill in all the required fields.");
        return;
    }
    
    if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
    } else {
        // Submit the form when the last step is reached
        document.getElementById('multiStepForm').submit();
    }
}

function prevStep() {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
}

// Simple validation to ensure fields in the current step are filled
function validateStep(stepIndex) {
    const currentStepFields = document.querySelectorAll(`.step:nth-child(${stepIndex + 1}) input, .step:nth-child(${stepIndex + 1}) select`);
    
    for (const field of currentStepFields) {
        if (field.hasAttribute('required') && !field.value) {
            return false;
        }
    }
    return true;
}

    </script>
    <?php include_once('includes/footer.php'); ?>
</body>
</html>
