<?php
include('includes/dbconnection.php');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['hlmsuid'])) {
    die("User not logged in.");
}

// Get user ID from session
$UserID = $_SESSION['hlmsuid'];

try {
    // Fetch user details from tbluser
    $stmt_user = $dbh->prepare("SELECT * FROM tbluser WHERE ID = :userid"); // Ensure the correct column name
    $stmt_user->bindParam(':userid', $UserID, PDO::PARAM_INT);
    
    // Execute the query and check for success
    if (!$stmt_user->execute()) {
        die("Query failed: " . implode(", ", $stmt_user->errorInfo()));
    }

    // Fetch the user data
    $userData = $stmt_user->fetch(PDO::FETCH_ASSOC);
    if ($userData === false) {
        die("User data not found.");
    }

    // Check if the user already has an application in tblapplication
    $stmt_application = $dbh->prepare("SELECT * FROM tblapplication WHERE UserID = :userid"); // Ensure UserID is correct here too
    $stmt_application->bindParam(':userid', $UserID, PDO::PARAM_INT);
    
    // Execute the query and check for success
    if (!$stmt_application->execute()) {
        die("Query failed: " . implode(", ", $stmt_application->errorInfo()));
    }

    // Fetch the application data
    $applicationData = $stmt_application->fetch(PDO::FETCH_ASSOC);
    if ($applicationData === false) {
        // Handle the case where no application data is found
        $applicationData = []; // Set to empty array if no data is found
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>




<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Home Loan Management System::Application Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- font-awesome icons -->
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
    <!-- online fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">

    <style>
        

        h2 {
            margin-bottom: 40px;
            font-weight: 700;
        }

        /* Step Indicator Container */
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .step {
            width: 18%;
            text-align: center;
            font-weight: bold;
            color: #aaa;
            position: relative;
            padding-bottom: 10px;
        }

        /* Connector line between steps */
        .step:before {
            content: "";
            position: absolute;
            top: 15px;
            left: 50%;
            width: 100%;
            height: 2px;
            background-color: #ddd;
            z-index: -1;
        }

        .step:first-child:before {
            display: none; /* Remove line for first step */
        }

        /* Active step */
        .step.active {
            color: #f4511e;
        }

        .step.active:before {
            background-color: #f4511e;
        }

        /* Style for form sections */
        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        /* Progress Bar Styling */
        .progress {
            height: 20px;
            margin-bottom: 30px;
        }

        .progress-bar {
            background-color: #f4511e;
        }

        /* Style for the form buttons */
        button {
            margin: 15px 0;
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .step {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <?php include_once('includes/header.php');?>

    <!-- banner -->
    <section class="banner-1"></section>
    <!-- //banner -->
    
    <div class="container mt-5">
        <h2 class="text-center">Application Form</h2>

        <!-- Progress Bar -->
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 20%" id="progressBar"></div>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator mb-5">
            <div class="step active">Personal Details</div>
            <div class="step">Employment Details</div>
            <div class="step">Bank Details</div>
            <div class="step">Financial Details</div>
            <div class="step">Next of Kin Details</div>
        </div>

        <form id="multiStepForm" method="POST" enctype="multipart/form-data">
            <!-- Step 1: Personal Details -->
<div class="form-step active" id="step-1">
    <h4>Personal Details</h4>
    
    <div class="form-group">
        <label for="title">Title</label>
        <select class="form-control" id="title" name="title" value="<?php echo $userData['Tittle']; ?>" required>
            <option value="Mr">Mr</option>
            <option value="Mrs">Mrs</option>
            <option value="Miss">Miss</option>
            <option value="Dr">Dr</option>
            <option value="Prof">Prof</option>
        </select>
    </div>

    <div class="form-group">
        <label for="FirstName">First Name</label>
        <input type="text" class="form-control" id="FirstName" name="FirstName" value="<?php echo $userData['FirstName']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $userData['LastName']; ?>"required>
    </div>
    
    <div class="form-group">
        <label for="mobilenumber">Mobile Number</label>
        <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" value="<?php echo $userData['MobileNumber']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $userData['Email']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="pannum">ID Number</label>
        <input type="text" class="form-control" id="pannum" name="pannum" value="<?php echo $userData['Aadhaar']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="gender">Gender</label>
        <select class="form-control" id="gender" name="gender"  value="<?php echo $userData['Gender']; ?>" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
    </div>

    <div class="form-group">
        <label for="homelanguage">Home Language</label>
        <select class="form-control" id="homelanguage" name="homelanguage" value="<?php echo $userData['Language']; ?>" required>
            <option value="English" selected>English</option>
            <option value="Afrikaans">Afrikaans</option>
            <option value="isiZulu">isiZulu</option>
            <option value="isiXhosa">isiXhosa</option>
            <option value="Sepedi">Sepedi</option>
            <option value="Setswana">Setswana</option>
            <option value="Sesotho">Sesotho</option>
            <option value="Xitsonga">Xitsonga</option>
            <option value="siSwati">siSwati</option>
            <option value="Tshivenda">Tshivenda</option>
            <option value="isiNdebele">isiNdebele</option>
        </select>
    </div>

    <div class="form-group">
        <label for="maritalstatus">Marital Status</label>
        <select class="form-control" id="maritalstatus" name="maritalstatus" value="<?php echo $userData['MaritalStatus']; ?>" required>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Divorced">Divorced</option>
            <option value="Widowed">Widowed</option>
        </select>
    </div>

    <div class="form-group">
        <label for="dependents">Number of Dependents</label>
        <input type="number" class="form-control" id="dependents" name="dependents" value="<?php echo $userData['NumberOfDependents']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="dateofbirth">Date of Birth</label>
        <input type="date" class="form-control" id="dateofbirth" name="dateofbirth" value="<?php echo $userData['DateOfBirth']; ?>" required>
    </div>

    <div class="form-group">
        <label for="nationality">Nationality</label>
        <select class="form-control" id="nationality" name="nationality"  value="<?php echo $userData['Nationality']; ?>" required>
            <option value="South Africa" selected>South Africa</option>
            <!-- List of all countries with South Africa as default -->
            <option value="Afghanistan">Afghanistan</option>
            <option value="Albania">Albania</option>
            <option value="Algeria">Algeria</option>
            <option value="zim">Zimbabwean</option>
            <!-- Add more countries as needed -->
        </select>
    </div>

    <div class="form-group">
        <label for="countryofbirth">Country of Birth</label>
        <select class="form-control" id="countryofbirth" name="countryofbirth" value="<?php echo $userData['CountryOfBirth']; ?>" required>
            <option value="South Africa" selected>South Africa</option>
            <!-- List of all countries with South Africa as default -->
            <option value="Afghanistan">Afghanistan</option>
            <option value="Albania">Albania</option>
            <option value="Algeria">Algeria</option>
            <option value="zim">Zimbabwe</option>
            <!-- Add more countries as needed -->
        </select>
    </div>

    <div class="form-group">
        <label for="pccopy">ID Copy</label>
        <input type="file" class="form-control" id="pccopy" name="pccopy" required>
    </div>

    <div class="form-group">
        <label for="address">Physical Address</label>
       <textarea class="form-control" id="address" name="address" rows="3" required>
    <?php echo isset($applicationData['Address']) ? htmlspecialchars($applicationData['Address'], ENT_QUOTES) : ''; ?>
</textarea>

    </div>

    <div class="form-group">
        <label for="addressproofdoc">Address Proof Type</label>
        <select class="form-control" id="addressproofdoc" name="addressproofdoc" required>
            <option value="">Select Address Proof Type</option>
            <option value="Electricity Bill">Electricity Bill</option>
            <option value="Bank Statement">Bank Statement</option>
            <option value="Other">Other</option>
        </select>
    </div>

    <div class="form-group">
        <label for="uaddproof">Address Proof Document</label>
        <input type="file" class="form-control" id="uaddproof" name="uaddproof" required>
    </div>

    <div class="form-group">
        <label for="profile">Profile Picture</label>
        <input type="file" class="form-control" id="profile" name="profile" required>
    </div>

    <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
</div>


           <!-- Step 2: Employment Details -->
<div class="form-step" id="step-2">
    <h4>Employment Details</h4>

    <div class="form-group">
        <label for="employername">Employer Name</label>
        <input type="text" class="form-control" id="employername" name="employername"  value="<?php echo isset($applicationData['EmployerName']) ? htmlspecialchars($applicationData['EmployerName'], ENT_QUOTES) : ''; ?>"  required>
    </div>
    
    <div class="form-group">
        <label for="employeraddress">Employer Address</label>
        <textarea class="form-control" id="employeraddress" name="employeraddress" rows="3" required>
    <?php echo isset($applicationData['EmployerAddress']) ? htmlspecialchars($applicationData['EmployerAddress'], ENT_QUOTES) : ''; ?>
</textarea>

    </div>
    
    <div class="form-group">
        <label for="employernumber">Employer Contact Number</label>
        <input type="text" class="form-control" id="employernumber" name="employernumber"  value="<?php echo isset($applicationData['EmployerNumber']) ? htmlspecialchars($applicationData['EmployerNumber'], ENT_QUOTES) : ''; ?>"  required>
    </div>
    
    <div class="form-group">
        <label for="appointmentdate">Date of Appointment</label>
        <input type="date" class="form-control" id="appointmentdate" name="appointmentdate"  value="<?php echo isset($applicationData['DateStartedWorking']) ? htmlspecialchars($applicationData['DateStartedWorking'], ENT_QUOTES) : ''; ?>"   required>
    </div>
    
    <div class="form-group">
        <label for="jobtitle">Job Title</label>
        <input type="text" class="form-control" id="jobtitle" name="jobtitle" 
       value="<?php echo isset($applicationData['JobTitle']) ? htmlspecialchars($applicationData['JobTitle'], ENT_QUOTES) : ''; ?>" 
       required>

    </div>
    
<div class="form-group">
    <label for="employmenttype">Employment Type</label>
    <select class="form-control" id="employmenttype" name="employmenttype" required>
        <option value="Permanent" <?php echo (isset($applicationData['EmploymentType']) && $applicationData['EmploymentType'] === 'Permanent') ? 'selected' : ''; ?>>Permanent</option>
        <option value="Self-employed" <?php echo (isset($applicationData['EmploymentType']) && $applicationData['EmploymentType'] === 'Self-employed') ? 'selected' : ''; ?>>Self-employed</option>
        <option value="Contract" <?php echo (isset($applicationData['EmploymentType']) && $applicationData['EmploymentType'] === 'Contract') ? 'selected' : ''; ?>>Contract</option>
    </select>
</div>

    
    <div class="form-group">
        <label for="latestpayslip">Latest Payslip</label>
        <input type="file" class="form-control" id="latestpayslip" name="latestpayslip" required>
    </div>
    
    <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
    <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
</div>


            <!-- Step 3: Bank Details -->
            <div class="form-step" id="step-3">
                <h4>Bank Details</h4>
               
                <div class="form-group">
                    <label for="accountnumber">Bank Name</label>
                    <select class="form-control" id="bankname" name="bankname"  value="<?php echo isset($applicationData['BankName']) ? htmlspecialchars($applicationData['BankName'], ENT_QUOTES) : ''; ?>" required>
                        <option value="">Select Bank Name</option>
                        <option value="capitec">Capitec Bank</option>
                        <option value="fnb">FNB</option>
                        <option value="absa">ABSA</option>
                        <option value="standardbank">Standard Bank</option>
                        <option value="afrianbank">African Bank</option>
                        <option value="bidvest">Bidvest Bank</option>
                        <option value="tymebank">Tyme Bank</option>
                    </select>
                </div>
                 <div class="form-group">
                    <label for="accountnumber">Account Number</label>
                    <input type="text" class="form-control" id="accountnumber" name="accountnumber"  value="<?php echo isset($applicationData['AccountNumber']) ? htmlspecialchars($applicationData['AccountNumber'], ENT_QUOTES) : ''; ?>"  required>
                </div>
                <div class="form-group">
                    <label for="accounttype">Account Type</label>
                    <select class="form-control" id="accounttype" name="accounttype"  value="<?php echo isset($applicationData['AccountType']) ? htmlspecialchars($applicationData['AccountType'], ENT_QUOTES) : ''; ?>" required>
                        <option value="">Select Account Type</option>
                        <option value="Savings">Savings</option>
                        <option value="Current">Current</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="accountholder">Account Holder Name</label>
                    <input type="text" class="form-control" id="accountholder" name="accountholder"  value="<?php echo isset($applicationData['AccountHolder']) ? htmlspecialchars($applicationData['AccountHolder'], ENT_QUOTES) : ''; ?>"  required>
                </div>
                <div class="form-group">
                    <label for="bankstatement">3Months Bank Statements</label>
                    <input type="file" class="form-control" id="bankstatement" name="bankstatement" required>
                </div>
                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
            </div>

            <!-- Step 4: Financial Details -->
            <div class="form-step" id="step-4">
                <h4>Financial Details</h4>
                
                <div class="form-group">
                    <label for="Loan">Loan Amount Requested</label>
                    <input type="text" class="form-control" id="loan" name="Loan" value="<?php echo isset($applicationData['ExpectedLoanAmount']) ? htmlspecialchars($applicationData['ExpectedLoanAmount'], ENT_QUOTES) : ''; ?>"required>
                </div>
                <div class="form-group">
                    <label for="monthlyincome">Monthly Income</label>
                    <input type="text" class="form-control" id="monthlyincome" name="monthlyincome" value="<?php echo isset($applicationData['MontlyIncome']) ? htmlspecialchars($applicationData['MontlyIncome'], ENT_QUOTES) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="exloan">Existing Loan?</label>
                    <select class="form-control" id="exloan" name="exloan" required>
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exloanamount">Total Expenses</label>
                    <input type="text" class="form-control" id="exloanamount" name="exloanamount" value="<?php echo isset($applicationData['TotalExpenses']) ? htmlspecialchars($applicationData['TotalExpenses'], ENT_QUOTES) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="emi">Remaining Amount</label>
                    <input type="text" class="form-control" id="emi" name="emi" value="<?php echo isset($applicationData['RemainingAmount']) ? htmlspecialchars($applicationData['RemainingAmount'], ENT_QUOTES) : ''; ?>" required>
                </div>
                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
            </div>

            <!-- Step 5: Guarantor Details -->
            <div class="form-step" id="step-5">
                <h4>Next of Kin Details</h4>
                <div class="form-group">
                    <label for="guarantorname">Next of Kin  Name</label>
                    <input type="text" class="form-control" id="guarantorname" name="guarantorname"  value="<?php echo isset($applicationData['GName']) ? htmlspecialchars($applicationData['GName'], ENT_QUOTES) : ''; ?>"  required>
                </div>
                <div class="form-group">
                    <label for="guarantoraddress">Next of Kin  Address</label>
                   <textarea class="form-control" id="guarantoraddress" name="guarantoraddress" rows="3" required>
    <?php echo isset($applicationData['Gaddress']) ? htmlspecialchars($applicationData['Gaddress'], ENT_QUOTES) : ''; ?>
</textarea>

                </div>
                <div class="form-group">
                    <label for="guarantorphonenumber">Next of Kin  Phone Number</label>
                    <input type="text" class="form-control" id="guarantorphonenumber" name="guarantorphonenumber"  value="<?php echo isset($applicationData['Gmobnum']) ? htmlspecialchars($applicationData['Gmobnum'], ENT_QUOTES) : ''; ?>"  required>
                </div>
                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 5;

        function showStep(step) {
            document.querySelectorAll(".form-step").forEach((stepDiv) => {
                stepDiv.classList.remove("active");
            });
            document.getElementById(`step-${step}`).classList.add("active");

            document.querySelectorAll(".step").forEach((stepIndicator) => {
                stepIndicator.classList.remove("active");
            });
            document.querySelectorAll(".step")[step - 1].classList.add("active");

            updateProgressBar(step);
        }

        function nextStep() {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        function updateProgressBar(step) {
            const progress = (step / totalSteps) * 100;
            document.getElementById("progressBar").style.width = progress + "%";
        }

        showStep(currentStep);
    </script>
    
<?php include_once('includes/footer.php');?>

<!-- js-->
<script src="js/jquery-2.2.3.min.js"></script>
<!-- js-->
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.js "></script>
<!-- //Bootstrap Core JavaScript -->
</body>

</html>
