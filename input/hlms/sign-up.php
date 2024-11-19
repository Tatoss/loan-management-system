<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mobno = $_POST['mobno'];
    $email = $_POST['email'];
    $aadhaar = $_POST['aadhaar'];
    $password = md5($_POST['password']);
    
    // Automatically generate a 5-digit PAN number
    $pan = rand(10000, 99999); 

    // Check if the mobile number or email is already registered
    $ret = "SELECT MobileNumber, Email FROM tbluser WHERE MobileNumber=:mobno OR Email=:email";
    $query = $dbh->prepare($ret);
    $query->bindParam(':mobno', $mobno, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() == 0) {
        // Insert new user data
        $sql = "INSERT INTO tbluser(FirstName, LastName, MobileNumber, Email, Aadhaar, PAN, Password) 
                VALUES (:fname, :lname, :mobno, :email, :aadhaar, :pan, :password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':mobno', $mobno, PDO::PARAM_INT);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':aadhaar', $aadhaar, PDO::PARAM_STR);
        $query->bindParam(':pan', $pan, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
            echo "<script>alert('You have signed up successfully!');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    } else {
        echo "<script>alert('This mobile number or email already exists. Please try again');</script>";
    }
}
?>

<!DOCTYPE HTML>
<html lang="zxx">
<head>
    <title>Home Loan Management System::Sign Up Page</title>
    
    <!-- Mobile responsive meta tag -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
    
    <!-- Online fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
</head>

<body>
    <?php include_once('includes/header.php'); ?>

    <!-- Banner -->
    <section class="banner-1"></section>
    
    <!-- Registration Form -->
    <section class="contact py-5">
        <div class="container py-md-4 mt-md-3">
            <h2 class="heading-agileinfo">Registration Form<span>Speed Up The Loan Process</span></h2>
            <span class="w3-line black"></span>
            <div class="inner-sec-w3layouts-agileinfo mt-md-5 pt-5">
                <div class="contact_grid_right mt-5">
                    <h6>Please fill this form to register with us.</h6>
                    <form method="post" name="signup" action="" onsubmit="return checkpass();">
                        <div class="contact_left_grid">
                            <input type="text" name="fname" placeholder="First Name" required="true" class="form-control">
                            <br>
                            <input type="text" name="lname" placeholder="Last Name" required="true" class="form-control">
                            <br>
                            <input type="text" name="email" placeholder="Email" required="true" class="form-control">
                            <br>
                            <input placeholder="Mobile Number:" type="text" tabindex="3" name="mobno" required="true" maxlength="10" pattern="[0-9]+" class="form-control">
                            <br>
                            <input placeholder="ID number (13 digits)" type="text" tabindex="4" name="aadhaar" required="true" maxlength="13" pattern="[0-9]+" class="form-control">
                            <br>
                            <input placeholder="Password" type="password" tabindex="5" name="password" required="true" id="password" class="form-control">
                            <br>
                            <p>
                                <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                                <input type="reset" value="Clear" class="btn btn-secondary">
                            </p>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                    <p><a href="forgot-password.php">Forgot your password?</a></p>
                    <p><a href="sign-in.php">Sign In</a></p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>

    <!-- JS -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>
