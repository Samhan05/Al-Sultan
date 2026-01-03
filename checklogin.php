<?php
session_start();
include('config.php');

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $row['username'];
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['avatar'] = $row['avatar'];

    if ($row['role'] == 'Admin') header("Location: admin_dashboard.php");
    else header("Location: index.php");
} else {
    echo "<script>alert('Invalid Credentials'); window.location='login.php';</script>";
}
?>