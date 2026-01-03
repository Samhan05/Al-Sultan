<?php 
include('config.php');
include('header.php'); 

$id = (int)$_GET['id'];
$car = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM cars WHERE id=$id"));

if(isset($_POST['reserve'])) {
    if(!isset($_SESSION['user_id'])) {
        header("Location: login.php"); exit();
    }
    
    $uid = $_SESSION['user_id'];
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    $today = date('Y-m-d');


    if ($date < $today) {
        echo "<script>alert('Error: You cannot reserve a car for a past date.'); window.history.back();</script>";
        exit();
    }


    $check_exists = mysqli_query($conn, "SELECT id FROM reservations WHERE user_id = $uid AND car_id = $id AND status != 'Cancelled'");
    
    if (mysqli_num_rows($check_exists) > 0) {
        echo "<script>alert('You already have an active request for this vehicle.'); window.location='profile.php';</script>";
        exit();
    }


    if ($car['status'] == 'Sold') {
        echo "<script>alert('This vehicle is no longer available.'); window.location='showroom.php';</script>";
        exit();
    }
    
    $sql = "INSERT INTO reservations (user_id, car_id, reserve_date, message) VALUES ('$uid', '$id', '$date', '$msg')";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Request Sent'); window.location='profile.php';</script>";
    }
}
?>

<div class="container my-5 py-5">
    <div class="row g-5">
        <div class="col-md-7">
            <img src="uploads/<?php echo $car['image']; ?>" class="img-fluid rounded border border-secondary shadow-lg">
        </div>
        <div class="col-md-5">
            <div class="card h-100 p-4">
                <h6 class="text-warning text-uppercase letter-spacing-2"><?php echo $car['make']; ?></h6>
                <h1 class="text-white"><?php echo $car['model']; ?></h1>
                <h2 class="text-gold mb-4">$<?php echo number_format($car['price']); ?></h2>
                <p class="text-white-50"><?php echo $car['description']; ?></p>
                
                <hr class="border-secondary my-4">
                <h5 class="text-white">Specifications</h5>
                <p class="text-white" style="font-weight: 600;"><?php echo $car['specs']; ?></p>
                <hr class="border-secondary my-4">
                
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'Customer'): ?>
                    <form method="post">
                        <h5 class="text-white small text-uppercase mb-3">Book a Viewing</h5>
                        <input type="date" name="date" class="form-control mb-3" required>
                        <textarea name="message" class="form-control mb-3" placeholder="Additional details (Optional)" rows="2"></textarea>
                        <button type="submit" name="reserve" class="btn btn-gold w-100">Send Request</button>
                    </form>
                <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'): ?>
                    <a href="edit_car.php?id=<?php echo $car['id']; ?>" class="btn btn-outline-info w-100">Manage Record</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-gold w-100">Login to Reserve</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>