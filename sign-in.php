<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) {
    $mobOrEmail = $_POST['mobno'];  // This will store either mobile number or email
    $password = md5($_POST['password']);
    
    // SQL query to check if user exists with either mobile number or email
    $sql = "SELECT ID FROM tbluser WHERE (MobileNumber=:mobOrEmail OR Email=:mobOrEmail) AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':mobOrEmail', $mobOrEmail, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['hlmsuid'] = $result->ID;
        }
        $_SESSION['login'] = $_POST['mobno'];
        echo "<script type='text/javascript'> document.location ='index.php'; </script>";
    } else {
        echo "<script>alert('Invalid login details. Please try again.');</script>";
    }
}
?>

<!DOCTYPE HTML>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterwise Finance - Login</title>

    <!-- Bootstrap and Font Awesome CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/fontawesome-all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
</head>

<body>
    <?php include_once('includes/header.php'); ?>

    <!-- Banner -->
    <section class="banner-1"></section>

    <!-- Login Form -->
    <section class="contact py-5">
        <div class="container py-md-4 mt-md-3">
            <h2 class="heading-agileinfo">Login Form<span>Speed Up The Loan Process</span></h2>
            <span class="w3-line black"></span>
            <div class="inner-sec-w3layouts-agileinfo mt-md-5 pt-5">
                <div class="contact_grid_right mt-5">
                    <h6>Existing user, please fill in the form below to log in.</h6>
                    <form method="post" name="login">
                        <div class="contact_left_grid">
                            <!-- Input field for mobile number or email -->
                            <input placeholder="Mobile Number or Email" type="text" tabindex="3" name="mobno" required="true" class="form-control">
                            <br>
                            <input placeholder="Password" type="password" tabindex="4" name="password" required="true" id="password" class="form-control">
                            <br>
                            <p style="padding-top: 30px;">
                                <input type="submit" value="Submit" name="login" class="btn btn-primary">
                                <input type="reset" value="Clear" class="btn btn-secondary">
                            </p>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                    <p><a href="forgot-password.php">Forgot your password?</a></p>
                    <p><a href="sign-up.php">Signup</a></p>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('includes/footer.php'); ?>

    <!-- JavaScript -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>
