<?php
session_start();

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('includes/dbconnection.php');

// Check if user is logged in
if (!isset($_SESSION['hlmsuid']) || strlen($_SESSION['hlmsuid']) == 0) {
    header('Location: logout.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
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
        $nextPayday = htmlspecialchars(trim($_POST['nextpayday']));
        $preferredDebitOrderDate = htmlspecialchars(trim($_POST['preferreddebitorderdate']));
        $employerName = htmlspecialchars(trim($_POST['employername']));
        $employerNumber = htmlspecialchars(trim($_POST['employernumber']));
        $dateStartedWorking = htmlspecialchars(trim($_POST['datestartedworking']));
        
        // Handle file uploads
        $uploads_dir = [
            'pccopy' => 'pancardfile/',
            'uaddproof' => 'addfile/',
            'profile' => 'images/',
            'latestpayslip' => 'payslips/'
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

        // Generate a unique application number
        $applicationno = mt_rand(10000, 99999);

        // Insert data into the database
        $sql = "INSERT INTO tblapplication 
                (UserID, ApplicationNumber, PanNumber, PanCardCopy, Address, AddressProofType, AdressDoc, ServiceType, MontlyIncome, ExistingLoan, ExpectedLoanAmount, ProfilePic, Tenure, GName, Gmobnum, Gemail, Gaddress, LatestPayslip, NextPayday, PreferredDebitOrderDate, EmployerName, EmployerNumber, DateStartedWorking) 
                VALUES 
                (:uid, :applicationno, :pannum, :pccopy, :address, :addtypeproof, :uaddproof, :sertype, :mincome, :exloan, :explamt, :profile, :tenure, :gname, :gmobnum, :gemail, :gaddress, :latestpayslip, :nextpayday, :preferreddebitorderdate, :employername, :employernumber, :datestartedworking)";

        $query = $dbh->prepare($sql);
        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->bindParam(':applicationno', $applicationno, PDO::PARAM_STR);
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
        $query->bindParam(':tenure', $tenure, PDO::PARAM_STR);
        $query->bindParam(':gname', $gname, PDO::PARAM_STR);
        $query->bindParam(':gmobnum', $gmobnum, PDO::PARAM_STR);
        $query->bindParam(':gemail', $gemail, PDO::PARAM_STR);
        $query->bindParam(':gaddress', $gaddress, PDO::PARAM_STR);
        $query->bindParam(':latestpayslip', $latestpayslip, PDO::PARAM_STR);
        $query->bindParam(':nextpayday', $nextPayday, PDO::PARAM_STR);
        $query->bindParam(':preferreddebitorderdate', $preferredDebitOrderDate, PDO::PARAM_STR);
        $query->bindParam(':employername', $employerName, PDO::PARAM_STR);
        $query->bindParam(':employernumber', $employerNumber, PDO::PARAM_STR);
        $query->bindParam(':datestartedworking', $dateStartedWorking, PDO::PARAM_STR);

        $query->execute();

        // Check if insertion was successful
        $LastInsertId = $dbh->lastInsertId();
        if ($LastInsertId) {
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
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterwise System::Loan Application Form</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
    <!-- Additional Bootstrap CSS for step indicators -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Step Indicator Styles */
        .step { display: none; }
        .step.active { display: block; }
        .step-header { display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 20px; }
        .step-header .step-indicator {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-bottom: 2px solid #ccc;
            cursor: pointer;
        }
        .step-header .step-indicator.active {
            font-weight: bold;
            color: #0d6efd;
            border-color: #0d6efd;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .step-header .step-indicator {
                flex: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include_once('includes/header2.php'); ?>

    <!-- Banner Section -->
    <section class="banner-1">
        <!-- You can add banner content here -->
    </section>

    <!-- Application Form Section -->
    <section class="contact py-5">
        <div class="container py-md-4 mt-md-3">
            <h2 class="heading-agileinfo">Application Form<span>Fill the following details</span></h2>
            <div class="inner-sec-w3layouts-agileinfo mt-md-5 pt-5">
                <div class="contact_grid_right mt-5">
                    <h6>Please Fill the Following Details</h6>
                    <div class="container my-4 p-3 bg-light border rounded">
                        <!-- Display Success or Error Messages -->
                        <?php if(isset($_SESSION['success'])) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                            </div>
                        <?php } ?>

                        <?php if(isset($_SESSION['error'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php } ?>

                        <form method="post" enctype="multipart/form-data" id="multiStepForm" action="applicationtest.php">
                            <!-- Step Progress Indicator -->
                            <div class="step-header mb-4">
                                <div class="step-indicator active" id="step-1-indicator">Step 1: User Info</div>
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
                                        $uid = $_SESSION['hlmsuid'];
                                        $sql = "SELECT * FROM tbluser WHERE ID = :uid";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if($query->rowCount() > 0) {
                                            foreach($results as $row) {               
                                    ?>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Name:</label>
                                                <input type="text" value="<?php echo htmlspecialchars($row->FirstName); ?>" name="fname" class="form-control" readonly required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Mobile Number:</label>
                                                <input type="text" value="<?php echo htmlspecialchars($row->MobileNumber); ?>" name="mobno" class="form-control" readonly required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Profile Photo:</label>
                                            <input type="file" class="form-control" name="profile" accept=".jpg,.jpeg,.png,.gif" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ID Number:</label>
                                            <input type="text" value="<?php echo htmlspecialchars($row->Aadhaar); ?>" name="pannum" class="form-control" readonly required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Upload ID Copy:</label>
                                            <input type="file" name="pccopy" class="form-control" accept=".doc,.docs,.pdf" required>
                                        </div>
                                    </div>
                                    <?php
                                            }
                                        }
                                    ?>
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
                                                <option value="Bank Statement">Bank Statement</option>
                                                <option value="Municipal">Municipal</option>
                                                <!-- Add more options as needed -->
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Upload Proof of Address:</label>
                                            <input type="file" name="uaddproof" class="form-control" accept=".doc,.docs,.pdf" required>
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
                                                <input type="number" name="monthlyincome" class="form-control" min="0" required>
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
                                                <input type="number" name="explamt" class="form-control" min="0" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tenure (in months):</label>
                                                <input type="number" name="tenure" class="form-control" min="1" required>
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
                                                <input type="tel" name="gmobnum" class="form-control" pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number" required>
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
                                                <input type="tel" name="employernumber" class="form-control" pattern="[0-9]{10}" title="Enter a valid 10-digit number" required>
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
                                            <input type="file" name="latestpayslip" class="form-control" accept=".doc,.docs,.pdf" required>
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

    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>

    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS (Optional, for enhanced interactivity) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript for Multi-Step Form -->
    <script>
        let currentStep = 0;
        showStep(currentStep); // Display the first step

        function showStep(n) {
            const steps = document.querySelectorAll('.step');
            const indicators = document.querySelectorAll('.step-indicator');

            // Hide all steps and remove active class from indicators
            steps.forEach((step, index) => {
                step.classList.remove('active');
                step.style.display = 'none';
                indicators[index].classList.remove('active');
            });

            // Show the current step and activate the corresponding indicator
            steps[n].classList.add('active');
            steps[n].style.display = 'block';
            indicators[n].classList.add('active');

            // Toggle button visibility
            document.getElementById('prevBtn').style.display = (n === 0) ? 'none' : 'inline-block';

            // Change "Next" button to "Submit" on the last step
            document.getElementById('nextBtn').textContent = (n === (steps.length - 1)) ? 'Submit' : 'Next';
        }

        function nextStep() {
            const steps = document.querySelectorAll('.step');

            // Validate current step before moving to the next step
            if (!validateStep(currentStep)) {
                alert("Please fill in all the required fields correctly.");
                return;
            }

            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            } else {
                // Final submission
                document.getElementById('multiStepForm').submit();
            }
        }

        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

        // Simple validation to ensure required fields in the current step are filled
        function validateStep(stepIndex) {
            const currentStepElement = document.querySelectorAll('.step')[stepIndex];
            const requiredFields = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');

            let valid = true;

            requiredFields.forEach(field => {
                if (field.type === 'file') {
                    if (!field.value) {
                        valid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                } else if (field.type === 'checkbox' || field.type === 'radio') {
                    if (!field.checked) {
                        valid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                } else {
                    if (!field.value.trim()) {
                        valid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                }
            });

            return valid;
        }
    </script>
</body>
</html>
