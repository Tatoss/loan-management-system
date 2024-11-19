<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hlmsaid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Enterwise || User Checks</title>
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
        <!-- partial:partials/_navbar.html -->
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h3>User Checks</h3>
                                    <div class="table-responsive pt-3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Full Name</th>
                                                    <th>Mobile Number</th>
                                                    <th>ID Number</th>
                                                    <th>Date of Registration</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM tbluser";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) { ?>
                                                        <tr class="table-info">
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($row->FirstName); ?></td>
                                                            <td><?php echo htmlentities($row->MobileNumber); ?></td>
                                                            <td><?php echo htmlentities($row->Aadhaar); ?></td>
                                                            <td><?php echo htmlentities($row->RegDate); ?></td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a href="kyc_verify.php?id=<?php echo htmlentities($row->ID); ?>" class="btn btn-success">KYC Verify</a>
                                                                    <a href="check_affordability.php?id=<?php echo htmlentities($row->ID); ?>" class="btn btn-warning">Check Affordability</a>
                                                                    <a href="verify_bank.php?id=<?php echo htmlentities($row->ID); ?>" class="btn btn-info">Verify Bank Details</a>
                                                                    <a href="check_credit.php?id=<?php echo htmlentities($row->ID); ?>" class="btn btn-dark">Check Credit Score</a>
                                                                <a href="verify_id.php?id=<?php echo htmlentities($row->ID); ?>" class="btn btn-primary">Verify ID</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                <?php 
                                                        $cnt = $cnt + 1;
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <?php include_once('includes/footer.php'); ?>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <!-- endinject -->
</body>

</html>
<?php } ?>
