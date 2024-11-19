<?php
session_start();
error_reporting(0);
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

    // Update user details in the database
    $sql = "UPDATE tbluser SET FirstName=:FirstName, LastName=:LastName, MobileNumber=:MobileNumber, Email=:Email, Aadhaar=:Aadhaar, PAN=:PAN, Nationality=:Nationality, Title=:Title, Gender=:Gender, HomeLanguage=:HomeLanguage, MaritalStatus=:MaritalStatus, NumberOfDependents=:NumberOfDependents, CountryOfBirth=:CountryOfBirth, DateOfBirth=:DateOfBirth WHERE ID=:uid";
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
    $query->execute();

    if ($query->rowCount() > 0) {
        echo "<script>alert('Profile updated successfully');</script>";
    } else {
        echo "<script>alert('No changes made or error updating profile');</script>";
    }
}

// Fetch user details to display
$sql = "SELECT * FROM tbluser WHERE ID=:uid";
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
    <style>
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
    </style>
</head>
<body>
    
    <?php include_once('includes/header.php'); ?>

<div class="container mt-5 form-container">
    <h2>Update Your Profile</h2>
    <form method="post">
        <!-- Basic Information -->
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
        <!-- Contact Information -->
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
        <!-- Identification Numbers -->
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
        <!-- Nationality and Title -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Nationality</label>
                <select name="Nationality" class="form-control" required>
                    <option value="" disabled>Select your nationality</option>
                    <!-- Add options for various countries -->
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Title</label>
                <input type="text" name="Title" class="form-control" value="<?php echo htmlentities($result->Title); ?>">
            </div>
        </div>
        <!-- Personal Details -->
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
        <!-- Marital and Family Information -->
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
        <!-- Country of Birth and Date of Birth -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Country of Birth</label>
                <select name="CountryOfBirth" class="form-control" required>
                    <option value="" disabled>Select your country</option>
                    <!-- Add options for various countries -->
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Date of Birth</label>
                <input type="date" name="DateOfBirth" class="form-control" value="<?php echo htmlentities($result->DateOfBirth); ?>">
            </div>
        </div>
        <!-- Additional Details - Add as needed -->
        <!-- Example additional field for Address -->
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
        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary" style="background-color: #fe5411; border-color: #fe5411;">Update Profile</button>
        </div>
    </form>
</div>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include_once('includes/footer.php'); ?>
</body>
</html>
