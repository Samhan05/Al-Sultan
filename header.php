<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    include_once('config.php');
    
    if ($conn) {
        $token = mysqli_real_escape_string($conn, $_COOKIE['remember_me']);
        $sql = "SELECT * FROM users WHERE remember_token = '$token' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['role'] = $user['role'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AL-SULTAN MOTORCARS</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        
   <a class="navbar-brand animate__animated animate__fadeIn d-flex align-items-center" href="index.php">
    <img src="uploads/logo.png" alt="Al-Sultan Logo" width="50" height="50" class="me-3 d-inline-block align-text-top rounded-circle shadow-sm" style="border: 1px solid var(--gold);">
    
    <span class="d-none d-sm-inline" style="font-family: 'Cinzel', serif; letter-spacing: 1px;">
        AL-SULTAN <span class="text-white">MOTORCARS</span>
    </span>
</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="showroom.php">Inventory</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle btn btn-outline-light border-0" href="#" data-bs-toggle="dropdown" style="color: var(--gold) !important;">
                            <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                            <?php if($_SESSION['role'] == 'Admin'): ?>
                                <li><a class="dropdown-item" href="admin_dashboard.php">Control Panel</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                          
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php">Sign Out</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-3"><a class="btn btn-gold btn-sm px-4" href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>