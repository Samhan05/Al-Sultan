<?php
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    // 1. Update Username
    mysqli_query($conn, "UPDATE users SET username = '$username' WHERE id = '$uid'");
    $_SESSION['user_name'] = $username;

    // 2. Handle Profile Picture Upload
    if (!empty($_FILES['avatar']['name'])) {
        $avatar_name = time() . '_' . $_FILES['avatar']['name'];
        $target = "uploads/" . $avatar_name;
        
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
            // Update the database with the new filename
            mysqli_query($conn, "UPDATE users SET avatar = '$avatar_name' WHERE id = '$uid'");
        }
    }
    
    header("Location: profile.php?status=success");
    exit();
}