<?php
include("config.php");
session_start();
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM reservations WHERE id=$id");
header("Location: my_reservations.php");
?>