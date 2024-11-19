<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['hlmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // Prepare the delete statement
        $sql = "DELETE FROM tbluser WHERE ID = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($query->execute()) {
            // Redirect back with a success message
            header('location:view_users.php?msg=User deleted successfully');
        } else {
            // Redirect back with an error message
            header('location:view_users.php?msg=Error deleting user');
        }
    } else {
        // Redirect back if ID is not set
        header('location:view_users.php?msg=Invalid request');
    }
}
?>
