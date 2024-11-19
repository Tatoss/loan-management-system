<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hlmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Check if the ID is set in the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Prepare SQL statement to get user details
        $sql = "SELECT * FROM tbluser WHERE ID = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_OBJ);

        // Check if user exists
        if (!$user) {
            echo "User not found.";
            exit;
        }
    } else {
        echo "Invalid request.";
        exit;
    }

    // Handle form submission for updating user details
    if (isset($_POST['update'])) {
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $mobileNumber = $_POST['MobileNumber'];
        $email = $_POST['Email'];
        $aadhaar = $_POST['Aadhaar'];
        $pan = $_POST['PAN'];
        $nationality = $_POST['Nationality'];
        $title = $_POST['Title'];
        $gender = $_POST['Gender'];
        $homeLanguage = $_POST['HomeLanguage'];
        $maritalStatus = $_POST['MaritalStatus'];
        $numberOfDependents = $_POST['NumberOfDependents'];
        $countryOfBirth = $_POST['CountryOfBirth'];
        $dateOfBirth = $_POST['DateOfBirth'];

        // Update user details in the database
        $updateSql = "UPDATE tbluser SET 
            FirstName = :firstName,
            LastName = :lastName,
            MobileNumber = :mobileNumber,
            Email = :email,
            Aadhaar = :aadhaar,
            PAN = :pan,
            Nationality = :nationality,
            Title = :title,
            Gender = :gender,
            HomeLanguage = :homeLanguage,
            MaritalStatus = :maritalStatus,
            NumberOfDependents = :numberOfDependents,
            CountryOfBirth = :countryOfBirth,
            DateOfBirth = :dateOfBirth
            WHERE ID = :id";

        $updateQuery = $dbh->prepare($updateSql);
        $updateQuery->bindParam(':firstName', $firstName);
        $updateQuery->bindParam(':lastName', $lastName);
        $updateQuery->bindParam(':mobileNumber', $mobileNumber);
        $updateQuery->bindParam(':email', $email);
        $updateQuery->bindParam(':aadhaar', $aadhaar);
        $updateQuery->bindParam(':pan', $pan);
        $updateQuery->bindParam(':nationality', $nationality);
        $updateQuery->bindParam(':title', $title);
        $updateQuery->bindParam(':gender', $gender);
        $updateQuery->bindParam(':homeLanguage', $homeLanguage);
        $updateQuery->bindParam(':maritalStatus', $maritalStatus);
        $updateQuery->bindParam(':numberOfDependents', $numberOfDependents);
        $updateQuery->bindParam(':countryOfBirth', $countryOfBirth);
        $updateQuery->bindParam(':dateOfBirth', $dateOfBirth);
        $updateQuery->bindParam(':id', $id);

        if ($updateQuery->execute()) {
            header("Location: view_users.php?msg=User details updated successfully.");
            exit;
        } else {
            $errorMsg = "Error updating user details.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit User Details</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- endinject -->
    
</head>

<body>
    <div class="container-scroller">
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Edit User Details</h4>
                                    <?php if (isset($errorMsg)) { ?>
                                        <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
                                    <?php } ?>
                                    <form method="post">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="FirstName" class="form-control" value="<?php echo htmlentities($user->FirstName); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="LastName" class="form-control" value="<?php echo htmlentities($user->LastName); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile Number</label>
                                            <input type="number" name="MobileNumber" class="form-control" value="<?php echo htmlentities($user->MobileNumber); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="Email" class="form-control" value="<?php echo htmlentities($user->Email); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>ID Number</label>
                                            <input type="text" name="Aadhaar" class="form-control" value="<?php echo htmlentities($user->Aadhaar); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>User Number</label>
                                            <input type="text" name="PAN" class="form-control" value="<?php echo htmlentities($user->PAN); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Nationality</label>
                                            <input type="text" name="Nationality" class="form-control" value="<?php echo htmlentities($user->Nationality); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" name="Title" class="form-control" value="<?php echo htmlentities($user->Title); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <input type="text" name="Gender" class="form-control" value="<?php echo htmlentities($user->Gender); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Home Language</label>
                                            <input type="text" name="HomeLanguage" class="form-control" value="<?php echo htmlentities($user->HomeLanguage); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Marital Status</label>
                                            <input type="text" name="MaritalStatus" class="form-control" value="<?php echo htmlentities($user->MaritalStatus); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Number of Dependents</label>
                                            <input type="number" name="NumberOfDependents" class="form-control" value="<?php echo htmlentities($user->NumberOfDependents); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Country of Birth</label>
                                            <input type="text" name="CountryOfBirth" class="form-control" value="<?php echo htmlentities($user->CountryOfBirth); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="date" name="DateOfBirth" class="form-control" value="<?php echo htmlentities($user->DateOfBirth); ?>">
                                        </div>
                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                        <a href="view_users.php" class="btn btn-secondary">Cancel</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
    <script src="vendors/base/vendor.bundle.base.js"></script>
</body>

</html>
