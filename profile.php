<?php
session_start();
error_reporting(1);
include('includes/dbconnection.php');

// Check if user is logged in
if (strlen($_SESSION['hlmsuid']) == 0) {
    header('Location: logout.php');
    exit();
}

// Get the logged-in user's ID from the session
$uid = $_SESSION['hlmsuid'];

// If the form is submitted, update the user details
if (isset($_POST['update'])) {
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $MobileNumber = $_POST['MobileNumber'];
    $Email = $_POST['Email'];
    $Aadhaar = $_POST['Aadhaar'];
    $PAN = $_POST['PAN'];
    $Nationality = $_POST['Nationality'];
    $Title = $_POST['Title'];
    $Gender = $_POST['Gender'];
    $HomeLanguage = $_POST['HomeLanguage'];
    $MaritalStatus = $_POST['MaritalStatus'];
    $NumberOfDependents = $_POST['NumberOfDependents'];
    $CountryOfBirth = $_POST['CountryOfBirth'];
    $DateOfBirth = $_POST['DateOfBirth'];
    $Address = $_POST['Address'];
    $City = $_POST['City'];

    // Update user details in the database
    $sql = "UPDATE tbluser SET FirstName=:FirstName, LastName=:LastName, MobileNumber=:MobileNumber, Email=:Email, Aadhaar=:Aadhaar, PAN=:PAN, Nationality=:Nationality, Title=:Title, Gender=:Gender, HomeLanguage=:HomeLanguage, MaritalStatus=:MaritalStatus, NumberOfDependents=:NumberOfDependents, CountryOfBirth=:CountryOfBirth, DateOfBirth=:DateOfBirth, Address=:Address, City=:City WHERE ID=:uid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uid', $uid, PDO::PARAM_INT);
    $query->bindParam(':FirstName', $FirstName, PDO::PARAM_STR);
    $query->bindParam(':LastName', $LastName, PDO::PARAM_STR);
    $query->bindParam(':MobileNumber', $MobileNumber, PDO::PARAM_INT);
    $query->bindParam(':Email', $Email, PDO::PARAM_STR);
    $query->bindParam(':Aadhaar', $Aadhaar, PDO::PARAM_STR);
    $query->bindParam(':PAN', $PAN, PDO::PARAM_STR);
    $query->bindParam(':Nationality', $Nationality, PDO::PARAM_STR);
    $query->bindParam(':Title', $Title, PDO::PARAM_STR);
    $query->bindParam(':Gender', $Gender, PDO::PARAM_STR);
    $query->bindParam(':HomeLanguage', $HomeLanguage, PDO::PARAM_STR);
    $query->bindParam(':MaritalStatus', $MaritalStatus, PDO::PARAM_STR);
    $query->bindParam(':NumberOfDependents', $NumberOfDependents, PDO::PARAM_INT);
    $query->bindParam(':CountryOfBirth', $CountryOfBirth, PDO::PARAM_STR);
    $query->bindParam(':DateOfBirth', $DateOfBirth, PDO::PARAM_STR);
    $query->bindParam(':Address', $Address, PDO::PARAM_STR);
    $query->bindParam(':City', $City, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        echo "<script>alert('Profile updated successfully');</script>";
    } else {
        echo "<script>alert('No changes made or error updating profile');</script>";
    }
}

// Fetch user details to display
$sql = "SELECT ID, FirstName, LastName, MobileNumber, RegDate, Email, Aadhaar, PAN, Nationality, Title, Gender, HomeLanguage, MaritalStatus, NumberOfDependents, CountryOfBirth, DateOfBirth, Address, City FROM tbluser WHERE ID=:uid";
$query = $dbh->prepare($sql);
$query->bindParam(':uid', $uid, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

if (!$result) {
    echo "<script>alert('No user found');</script>";
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>User Profile Update</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
       <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- font-awesome icons -->
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
    <!-- online fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
    
    <style>
        /* Add custom styling for the form */
        body {
            background-color: #f4f4f9;
        }
        .form-container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-group label {
            font-weight: bold;
            color: #555;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    
     <?php include_once('includes/header.php');?>

    <!-- banner -->
    <section class="banner-1"></section>
    <!-- //banner -->
    
    <div class="container mt-5 form-container">
        <h2>Update Your Profile</h2>
        <form method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>First Name</label>
                    <input type="text" name="FirstName" class="form-control" value="<?php echo htmlentities($result->FirstName); ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Last Name</label>
                    <input type="text" name="LastName" class="form-control" value="<?php echo htmlentities($result->LastName); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Mobile Number</label>
                    <input type="text" name="MobileNumber" class="form-control" value="<?php echo htmlentities($result->MobileNumber); ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" name="Email" class="form-control" value="<?php echo htmlentities($result->Email); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>ID Number</label>
                    <input type="text" name="Aadhaar" class="form-control" value="<?php echo htmlentities($result->Aadhaar); ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>User Number</label>
                    <input type="text" name="PAN" class="form-control" value="<?php echo htmlentities($result->PAN); ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
    <label>Nationality</label>
    <select name="Nationality" class="form-control" required>
        <option value="" disabled>Select your nationality</option>
        <option value="South African" <?php echo ($result->Nationality == 'South African') ? 'selected' : ''; ?>>South African</option>
        <option value="American" <?php echo ($result->Nationality == 'American') ? 'selected' : ''; ?>>American</option>
        <option value="British" <?php echo ($result->Nationality == 'British') ? 'selected' : ''; ?>>British</option>
        <option value="Indian" <?php echo ($result->Nationality == 'Indian') ? 'selected' : ''; ?>>Indian</option>
        <option value="Canadian" <?php echo ($result->Nationality == 'Canadian') ? 'selected' : ''; ?>>Canadian</option>
        <option value="Australian" <?php echo ($result->Nationality == 'Australian') ? 'selected' : ''; ?>>Australian</option>
        <option value="German" <?php echo ($result->Nationality == 'German') ? 'selected' : ''; ?>>German</option>
        <option value="French" <?php echo ($result->Nationality == 'French') ? 'selected' : ''; ?>>French</option>
        <option value="Brazilian" <?php echo ($result->Nationality == 'Brazilian') ? 'selected' : ''; ?>>Brazilian</option>
        <option value="Japanese" <?php echo ($result->Nationality == 'Japanese') ? 'selected' : ''; ?>>Japanese</option>
        <!-- Add more countries as needed -->
    </select>
</div>

                <div class="form-group col-md-6">
                    <label>Title</label>
                    <input type="text" name="Title" class="form-control" value="<?php echo htmlentities($result->Title); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Gender</label>
                    <input type="text" name="Gender" class="form-control" value="<?php echo htmlentities($result->Gender); ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Home Language</label>
                    <input type="text" name="HomeLanguage" class="form-control" value="<?php echo htmlentities($result->HomeLanguage); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Marital Status</label>
                    <input type="text" name="MaritalStatus" class="form-control" value="<?php echo htmlentities($result->MaritalStatus); ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Number of Dependents</label>
                    <input type="number" name="NumberOfDependents" class="form-control" value="<?php echo htmlentities($result->NumberOfDependents); ?>">
                </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-6">
    <label>Country of Birth</label>
    <select name="CountryOfBirth" class="form-control" required>
        <option value="" disabled>Select your country</option>
        <option value="South Africa" <?php echo ($result->CountryOfBirth == 'South Africa') ? 'selected' : ''; ?>>South Africa</option>
        <option value="United States" <?php echo ($result->CountryOfBirth == 'United States') ? 'selected' : ''; ?>>United States</option>
        <option value="United Kingdom" <?php echo ($result->CountryOfBirth == 'United Kingdom') ? 'selected' : ''; ?>>United Kingdom</option>
        <option value="India" <?php echo ($result->CountryOfBirth == 'India') ? 'selected' : ''; ?>>India</option>
        <option value="Canada" <?php echo ($result->CountryOfBirth == 'Canada') ? 'selected' : ''; ?>>Canada</option>
        <option value="Australia" <?php echo ($result->CountryOfBirth == 'Australia') ? 'selected' : ''; ?>>Australia</option>
        <option value="Germany" <?php echo ($result->CountryOfBirth == 'Germany') ? 'selected' : ''; ?>>Germany</option>
        <option value="France" <?php echo ($result->CountryOfBirth == 'France') ? 'selected' : ''; ?>>France</option>
        <option value="Brazil" <?php echo ($result->CountryOfBirth == 'Brazil') ? 'selected' : ''; ?>>Brazil</option>
        <option value="Japan" <?php echo ($result->CountryOfBirth == 'Japan') ? 'selected' : ''; ?>>Japan</option>
        <!-- Add more countries as needed -->
    </select>
</div>

                <div class="form-group col-md-6">
                    <label>Date of Birth</label>
                    <input type="date" name="DateOfBirth" class="form-control" value="<?php echo htmlentities($result->DateOfBirth); ?>">
                </div>
            </div>
            
                 <div class="form-row">
            <div class="form-group col-md-6">
                <label>Address</label>
                <input type="text" name="Address" class="form-control" value="<?php echo htmlentities($result->Address); ?>">
            </div>
            <div class="form-group col-md-6">
                <label>City</label>
                <input type="text" name="City" class="form-control" value="<?php echo htmlentities($result->City); ?>">
            </div>
        </div>
            
            <div class="text-center">
                <button type="submit" class="btn btn-primary" name="update" style="background-color: #fe5411; border-color: #fe5411;">Update Profile</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <?php include_once('includes/footer.php');?>

<!-- js-->
<script src="js/jquery-2.2.3.min.js"></script>
<!-- js-->
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.js "></script>
<!-- //Bootstrap Core JavaScript -->
    
</body>
</html>
