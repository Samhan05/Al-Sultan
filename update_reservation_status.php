<?php
include('config.php');
session_start();

// Restriction: Direct access check
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    // Update reservation status and return to panel
    $sql = "UPDATE reservations SET status = '$status' WHERE id = '$id'";
    mysqli_query($conn, $sql);
}

header("Location: admin_dashboard.php");
exit();
?>