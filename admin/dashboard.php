<?php
session_start();
error_reporting(1);
include('includes/dbconnection.php');
if (strlen($_SESSION['hlmsaid']==0)) {
  header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Enterwise Loan Management System || Dashboard</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="container-scroller">
    <?php include_once('includes/header.php');?>

    <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php');?>

        <div class="main-panel">
            <div class="content-wrapper">
                <!-- Welcome message -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <?php
                        $aid = $_SESSION['hlmsaid'];
                        $sql = "SELECT AdminName, Email from tbladmin where ID=:aid";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':aid', $aid, PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                            foreach ($results as $row) { ?>
                                <h4 class="font-weight-bold text-dark animate__animated animate__fadeInDown">Hi, welcome back, <?php echo $row->AdminName; ?>!</h4>
                        <?php } } ?>
                    </div>
                </div>

                <!-- Dashboard Cards -->
                <div class="row">
                    <!-- Total Registered Users -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <?php
                                $sql1 = "SELECT * from tbluser";
                                $query1 = $dbh->prepare($sql1);
                                $query1->execute();
                                $totuser = $query1->rowCount();
                                ?>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users fa-2x text-primary mr-3"></i>
                                    <div>
                                        <h5 class="card-title">Total Users</h5>
                                        <h4><?php echo htmlentities($totuser); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Loan Applications -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <?php
                                $sql2 = "SELECT * from tblapplication where Status is null";
                                $query2 = $dbh->prepare($sql2);
                                $query2->execute();
                                $newloanapp = $query2->rowCount();
                                ?>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-alt fa-2x text-warning mr-3"></i>
                                    <div>
                                        <h5 class="card-title">New Loan Applications</h5>
                                        <h4><?php echo htmlentities($newloanapp); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Approved Loan Applications -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <?php
                                $sql3 = "SELECT * from tblapplication where Status='Approved'";
                                $query3 = $dbh->prepare($sql3);
                                $query3->execute();
                                $apploanapp = $query3->rowCount();
                                ?>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x text-success mr-3"></i>
                                    <div>
                                        <h5 class="card-title">Approved Loans</h5>
                                        <h4><?php echo htmlentities($apploanapp); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rejected Loan Applications -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <?php
                                $sql4 = "SELECT * from tblapplication where Status='Rejected'";
                                $query4 = $dbh->prepare($sql4);
                                $query4->execute();
                                $rejloanapp = $query4->rowCount();
                                ?>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-times-circle fa-2x text-danger mr-3"></i>
                                    <div>
                                        <h5 class="card-title">Rejected Loans</h5>
                                        <h4><?php echo htmlentities($rejloanapp); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Loan Applications Overview</h5>
                                <canvas id="loanOverviewChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">User Registrations</h5>
                                <canvas id="userRegistrationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- Base JS -->
<script src="vendors/base/vendor.bundle.base.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js for graphs -->
<script>
    // Loan Applications Overview Chart
    const loanOverviewCtx = document.getElementById('loanOverviewChart').getContext('2d');
    const loanOverviewChart = new Chart(loanOverviewCtx, {
        type: 'pie',
        data: {
            labels: ['Approved', 'Rejected', 'Pending'],
            datasets: [{
                label: 'Loan Applications',
                data: [<?php echo $apploanapp; ?>, <?php echo $rejloanapp; ?>, <?php echo $newloanapp; ?>],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
            }]
        }
    });

    // User Registration Chart
    const userRegistrationCtx = document.getElementById('userRegistrationChart').getContext('2d');
    const userRegistrationChart = new Chart(userRegistrationCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'User Registrations',
                data: [30, 50, 20, 40, 60, 80, <?php echo $totuser; ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }]
        }
    });
</script>
</body>
</html>
<?php } ?>
