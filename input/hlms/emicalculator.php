<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);
?>
<!DOCTYPE HTML>
<html lang="zxx">

<head>
    <title>Loan Calculator | EMI Calculator</title>
    
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- font-awesome icons -->
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
    <!-- //Custom Theme files -->
    <!-- online fonts -->
    <!-- titles -->
    <link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- body -->
    <link href="//fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
</head>

<body>
    
<?php include_once('includes/header.php');?>

    <!-- banner -->
    <section class="banner-1"></section>
    <!-- //banner -->

    <!--/loan calculator-->
    <section class="contact py-5">
        <div class="container py-md-4 mt-md-3">
            <h2 class="heading-agileinfo">Loan Calculator<span>Plan Your Repayments</span></h2>
            <span class="w3-line black"></span>

            <div class="inner-sec-w3layouts-agileinfo mt-md-5 pt-5">
                <div class="contact_grid_right mt-5">
                    <form method="post">
                        <div class="contact_left_grid">
                            <input type="text" name="lamount" placeholder="Loan Amount" pattern="[0-9]+" title="Only Numbers" required class="form-control">
                            
                            <label>Interest Rate:</label>
                            <input type="text" name="lrate" value="5%" readonly class="form-control">

                            <label>Select Payday:</label>
                            <input type="date" name="payday" required class="form-control">

                            <input type="submit" value="Submit" name="submit">
                            <input type="reset" value="Clear">
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>

                <?php if(isset($_POST['submit'])){?>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="4" style="font-size:22px; text-align:center;"> Loan Details</th>
                    </tr>

                    <tr>
                        <th>Loan Amount</th>
                        <td><?php echo $loan_amount = $_POST['lamount']; ?></td>
                        <th>Loan Interest</th>
                        <td>5%</td>
                    </tr>

                    <tr>
                        <th>Service Fee (R2/day)</th>
                        <td>R60 (for 30 days)</td>
                        <th>Initiation Fee (15%)</th>
                        <td><?php echo $initiation_fee = $loan_amount * 0.15; ?></td>
                    </tr>

                    <?php
                    // Calculate the total repayment for 30 days
                    $interest_rate = 0.05; // 5% interest
                    $service_fee = 2 * 30; // R2 per day for 30 days
                    $interest = $loan_amount * $interest_rate; // Interest for 30 days

                    // Calculate total repayment for 30 days
                    $total_repayment_30_days = $loan_amount + $interest + $initiation_fee + $service_fee;
                    ?>

                    <tr>
                        <th>Total Interest (30 Days)</th>
                        <td><?php echo $interest; ?></td>
                        <th>Total Repayment (30 Days)</th>
                        <td><?php echo $total_repayment_30_days; ?></td>
                    </tr>

                    <?php
                    // Calculate repayment after 30 days with additional interest
                    $payday = strtotime($_POST['payday']);
                    $today = strtotime(date('Y-m-d'));

                    $days_diff = ceil(($today - $payday) / (60 * 60 * 24)); // Days between today and payday

                    if ($days_diff > 30) {
                        $extra_interest_rate = 0.05; // Additional 5% interest for late repayment
                        $extra_interest = $loan_amount * $extra_interest_rate * ($days_diff - 30) / 30;

                        $total_repayment_late = $total_repayment_30_days + $extra_interest;
                    ?>
                    <tr>
                        <th>Late Repayment Days</th>
                        <td><?php echo $days_diff - 30; ?> Days</td>
                        <th>Extra Interest for Late Payment</th>
                        <td><?php echo $extra_interest; ?></td>
                    </tr>

                    <tr>
                        <th>Total Repayment (Late)</th>
                        <td colspan="3"><?php echo $total_repayment_late; ?></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>
        </div>
    </section>
    <!--//loan calculator-->

<?php include_once('includes/footer.php');?>

<!-- js-->
<script src="js/jquery-2.2.3.min.js"></script>
<!-- js-->
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.js "></script>
<!-- //Bootstrap Core JavaScript -->
</body>
</html>
