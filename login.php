<?php 
include('config.php');
session_start();

$error = "";

if(isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['username'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['role'] = $row['role'];

        if (isset($_POST['remember'])) {
            $token = bin2hex(random_bytes(32));
            
      
            $uid = $row['id'];
            $update_sql = "UPDATE users SET remember_token = '$token' WHERE id = '$uid'";
            mysqli_query($conn, $update_sql);
            
            setcookie('remember_me', $token, time() + (86400 * 30), "/");
        }

        if($row['role'] == 'Admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Incorrect email or password.";
    }
}

include('header.php'); 
?>

<div class="container my-5" style="min-height: 60vh; display: flex; align-items: center;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-lg" style="background: #fff;">
                <div class="card-header bg-dark text-center py-4 border-bottom border-warning border-3">
                    <h3 class="mb-0 text-white" style="font-family: 'Cinzel', serif;">Client Login</h3>
                </div>
                <div class="card-body p-4 p-md-5">
                    
                    <?php if($error): ?>
                        <div class="alert alert-danger text-center mb-4"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-muted" for="remember">Keep me signed in</label>
                        </div>
                        
                        <button type="submit" name="login" class="btn btn-gold w-100 py-2 mb-3">Sign In</button>
                        
                        <div class="text-center">
                            <a href="#" class="text-muted small text-decoration-none">Forgot Password?</a>
                            <hr class="my-3">
                            <p class="small text-muted mb-0">Not a member?</p>
                            <a href="signup.php" class="text-warning fw-bold text-decoration-none">Create an Account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>