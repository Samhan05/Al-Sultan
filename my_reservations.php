<?php 
include('config.php');
session_start();



if (!isset($_SESSION['user_id'])) {

    $is_auto_logged_in = false;
    
    if (isset($_COOKIE['remember_me'])) {
        $token = mysqli_real_escape_string($conn, $_COOKIE['remember_me']);
        $sql_remember = "SELECT * FROM users WHERE remember_token = '$token'";
        $result_remember = mysqli_query($conn, $sql_remember);
        
        if ($result_remember && mysqli_num_rows($result_remember) > 0) {
            $user = mysqli_fetch_assoc($result_remember);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $is_auto_logged_in = true;
        }
    }


    if (!$is_auto_logged_in) {
        header("Location: login.php");
        exit();
    }
}

include('header.php');

$uid = $_SESSION['user_id'];
$sql = "SELECT r.*, c.make, c.model, c.image FROM reservations r JOIN cars c ON r.car_id = c.id WHERE r.user_id = $uid";
$result = mysqli_query($conn, $sql);
?>

<div class="container my-5" style="min-height: 60vh;">
    <h2 class="mb-4">My Reservations</h2>
    
    <div class="row g-4">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-6 animate__animated animate__fadeInUp">
                <div class="card p-3 d-flex flex-row align-items-center shadow-sm border-0">
                    <img src="uploads/<?php echo $row['image']; ?>" width="120" class="rounded me-3" style="object-fit: cover; height: 80px;">
                    <div class="flex-grow-1">
                        <h5 class="text-warning mb-1"><?php echo $row['make'] . ' ' . $row['model']; ?></h5>
                        <p class="mb-1 text-muted small"><i class="far fa-calendar-alt me-1"></i> <?php echo $row['reserve_date']; ?></p>
                        <span class="badge bg-secondary"><?php echo $row['status'] ? $row['status'] : 'Pending'; ?></span>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <a href="edit_reservation.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-dark">Edit</a>
                        <a href="delete_reservation.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to cancel this reservation?');">Cancel</a>
                    </div>
                </div>
            </div>
        <?php } ?>
        
        <?php if(mysqli_num_rows($result) == 0): ?>
            <div class="col-12 text-center text-muted py-5">
                <div class="mb-3 display-1 text-muted opacity-25"><i class="far fa-calendar-times"></i></div>
                <h4>No active reservations found.</h4>
                <p class="mb-4">You haven't booked any viewings yet.</p>
                <a href="showroom.php" class="btn btn-gold px-4">Browse Our Fleet</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('footer.php'); ?>