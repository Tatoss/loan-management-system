<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);
?>
<!DOCTYPE HTML>
<html lang="zxx">

<head>
    <title>Affordability Calculator</title>
    
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
    <link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
    
    <style>
        


.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Soft shadow for card */
}

h4 {
    font-size: 1.2rem; /* Adjust heading size for better visibility */
    color: #333; /* Dark color for better readability */
}

input[type="number"] {
    transition: border-color 0.3s; /* Smooth transition for border color */
}

input[type="number"]:focus {
    border-color: #fe5411; /* Change border color on focus */
    box-shadow: 0 0 5px rgba(254, 84, 17, 0.5); /* Subtle glow effect */
}

.btn-primary {
    background-color: #fe5411; /* Custom color for primary button */
    border: none; /* Remove border */
}

.btn-primary:hover {
    background-color: #d84a0e; /* Darker shade on hover */
}

.btn-secondary {
    background-color: #6c757d; /* Default Bootstrap secondary button color */
    border: none; /* Remove border */
}
</style>
    
</head>

<body>
    
<?php include_once('includes/header.php');?>

    <!-- banner -->
    <section class="banner-1"></section>
    <!-- //banner -->

    <!--/affordability calculator-->
    <section class="contact py-5">
        <div class="container py-md-4 mt-md-3">
            <h2 class="heading-agileinfo">Affordability Calculator<span>Plan Your Purchase</span></h2>
            <span class="w3-line black"></span>

            <div class="inner-sec-w3layouts-agileinfo mt-md-5 pt-5">
                <div class="contact_grid_right mt-5">
                     <form method="post"> 
        <div class="card p-4">
            <div class="contact_left_grid">
                <h4 class="mb-3">Net Income</h4>
                <div class="form-row mb-3">
                    <div class="col">
                        <input type="number" name="net_income" placeholder="Net Income" required class="form-control" min="0" step="0.01">
                    </div>
                </div>

                <h4 class="mb-3">Monthly Expenses</h4>
                <div class="form-row mb-3">
                    <div class="col">
                        <input type="number" name="food" placeholder="Food" required class="form-control" min="0" step="0.01">
                    </div>
                    <div class="col">
                        <input type="number" name="clothing" placeholder="Clothing" required class="form-control" min="0" step="0.01">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <input type="number" name="phone" placeholder="Phone" required class="form-control" min="0" step="0.01">
                    </div>
                    <div class="col">
                        <input type="number" name="utilities" placeholder="Utilities" required class="form-control" min="0" step="0.01">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <input type="number" name="transportation" placeholder="Transportation" required class="form-control" min="0" step="0.01">
                    </div>
                    <div class="col">
                        <input type="number" name="insurance" placeholder="Policies and Insurance" required class="form-control" min="0" step="0.01">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <input type="number" name="entertainment" placeholder="Entertainment" required class="form-control" min="0" step="0.01">
                    </div>
                    <div class="col">
                        <input type="number" name="education" placeholder="Education" required class="form-control" min="0" step="0.01">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <input type="number" name="savings" placeholder="Savings" required class="form-control" min="0" step="0.01">
                    </div>
                    <div class="col">
                        <input type="number" name="credit_cards" placeholder="Credit Card Payments" required class="form-control" min="0" step="0.01">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <input type="number" name="loans" placeholder="Loan Payments" required class="form-control" min="0" step="0.01">
                    </div>
                    <div class="col">
                        <input type="number" name="other" placeholder="Other Expenses" required class="form-control" min="0" step="0.01">
                    </div>
                </div>

                <div class="text-center">
                    <input type="submit" value="Calculate" name="calculate" class="btn btn-primary mr-2">
                    <input type="reset" value="Clear" class="btn btn-secondary">
                </div>
            </div>
        </div>
    </form>
                </div>

                <?php if(isset($_POST['calculate'])){ ?>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2" style="font-size:22px; text-align:center;">Affordability Details</th>
                    </tr>

                    <?php
                    // Gather input data
                    $net_income = $_POST['net_income'];
                    $expenses = $_POST['food'] + $_POST['clothing'] + $_POST['phone'] + $_POST['utilities'] + $_POST['transportation'] +
                                $_POST['insurance'] + $_POST['entertainment'] + $_POST['education'] + $_POST['savings'] +
                                $_POST['credit_cards'] + $_POST['loans'] + $_POST['other'];

                    // Calculate remaining surplus balance
                    $remaining_balance = $net_income - $expenses;

                    // Max Payment is set to 30% of remaining balance
                    $max_payment = $remaining_balance * 0.30;

                    // Possible cash price of an asset (Assuming a max loan period of 60 months at 10% interest)
                    $possible_cash_price = $max_payment * 60 / 1.10;

                    ?>

                    <tr>
                        <th>Total Monthly Expenses</th>
                        <td><?php echo 'R' . number_format($expenses, 2); ?></td>
                    </tr>
                    <tr>
                        <th>Remaining Surplus Balance</th>
                        <td><?php echo 'R' . number_format($remaining_balance, 2); ?></td>
                    </tr>
                    <tr>
                        <th>Maximum Monthly Payment</th>
                        <td><?php echo 'R' . number_format($max_payment, 2); ?></td>
                    </tr>
                    <tr>
                        <th>Possible Cash Price of an Asset</th>
                        <td><?php echo 'R' . number_format($possible_cash_price, 2); ?></td>
                    </tr>
                </table>

                <!-- Apply Now Button -->
                <a href="application-form.php" class="btn btn-primary">Apply Now</a>

                <?php } ?>
            </div>
        </div>
    </section>
    <!--//affordability calculator-->

<?php include_once('includes/footer.php');?>

<!-- js-->
<script src="js/jquery-2.2.3.min.js"></script>
<!-- js-->
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.js "></script>
<!-- //Bootstrap Core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
