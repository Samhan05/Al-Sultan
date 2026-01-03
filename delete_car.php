<?php
include("config.php");
session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];


mysqli_query($conn, "DELETE FROM cars WHERE id=$id");

header("Location: manage_cars.php");
exit();
?>