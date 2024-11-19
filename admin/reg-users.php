<?php
session_start();
error_reporting(1);
include('includes/dbconnection.php');
if (strlen($_SESSION['hlmsaid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Enterwise || View Loan Request</title>
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css">
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
                                    <h3>View Registered Users</h3>
                                    <div class="table-responsive pt-3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Full Name</th>
                                                    <th>Mobile Number</th>
                                                    <th>ID Number</th>
                                                    <th>Date of Registration</th>
                                                    <th>Loan Amount Disbursed</th>
                                                    <th>Application Date</th>
                                                    <th>Monthly Income</th>
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
                                                    foreach ($results as $row) {
                                                        // Fetch application details if available
                                                        $appSql = "SELECT LoanamountDisbursed, SubmitDate, MontlyIncome FROM tblapplication WHERE UserID = :userid";
                                                        $appQuery = $dbh->prepare($appSql);
                                                        $appQuery->bindParam(':userid', $row->ID, PDO::PARAM_INT);
                                                        $appQuery->execute();
                                                        $application = $appQuery->fetch(PDO::FETCH_OBJ);
                                                ?>
                                                        <tr class="table-info">
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($row->FirstName); ?></td>
                                                            <td><?php echo htmlentities($row->MobileNumber); ?></td>
                                                            <td><?php echo htmlentities($row->Aadhaar); ?></td>
                                                            <td><?php echo htmlentities($row->RegDate); ?></td>
                                                            <td>
                                                                <?php echo $application ? htmlentities($application->LoanamountDisbursed) : 'No application found'; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $application ? htmlentities($application->SubmitDate) : 'No application found'; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $application ? htmlentities($application->MontlyIncome) : 'No application found'; ?>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a href="view_application.php?userid=<?php echo htmlentities($row->ID); ?>" class="btn btn-secondary">View Application</a>
                                                                    <a href="send_email.php?userid=<?php echo htmlentities($row->ID); ?>" class="btn btn-info">Send Email</a>
                                                                    <a href="send_sms.php?userid=<?php echo htmlentities($row->ID); ?>" class="btn btn-warning">Send SMS</a>
                                                                    <a href="kyc_verify.php?id=<?php echo htmlentities($row->ID); ?>" class="btn btn-success">View Application</a>
            
                                                                    <a href="edit_user.php?id=<?php echo htmlentities($row->ID); ?>" class="btn btn-primary">Edit User</a>
                                                                    <a href="delete_user.php?id=<?php echo htmlentities($row->ID); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                <?php 
                                                        $cnt++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="9" class="text-center">No users found</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
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
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
</body>

</html>
<?php } ?>
