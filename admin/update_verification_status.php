<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['hlmsaid'] == 0)) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['status']) && isset($_POST['userID'])) {
    $status = $_POST['status'] === 'verified' ? 'Verified' : 'Unverified';
    $userID = $_POST['userID'];

    $query = $dbh->prepare("UPDATE tbluser SET VerificationStatus = :status WHERE ID = :id");
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':id', $userID, PDO::PARAM_INT);
    $query->execute();

    header("Location: user_checks.php");
    exit();
}
?>
