<?php 
include('header.php'); 
include('config.php');

if(isset($_POST['signup'])) {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$user', '$email', '$pass', 'Customer')";
    if(mysqli_query($conn, $sql)) echo "<script>alert('Account Created!'); window.location='login.php';</script>";
}
?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card p-5 shadow-lg" style="width: 400px;">
        <h2 class="text-center mb-4">Join Royale</h2>
        <form method="post">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-4" placeholder="Password" required>
            <button type="submit" name="signup" class="btn btn-gold w-100">Register</button>
        </form>
    </div>
</div>
<?php include('footer.php'); ?>