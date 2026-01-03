<?php 
include('config.php');
include('header.php');

$id = (int)$_GET['id'];
$uid = $_SESSION['user_id'];


$res = mysqli_query($conn, "SELECT * FROM reservations WHERE id=$id AND user_id=$uid");
$row = mysqli_fetch_assoc($res);

if (!$row) {
    header("Location: profile.php"); exit();
}

$today = date('Y-m-d');
$is_past = ($row['reserve_date'] < $today);
$is_locked = ($row['status'] == 'Approved' || $row['status'] == 'Confirmed' || $is_past);


if(isset($_POST['update'])) {
    if ($is_locked) {
        echo "<script>alert('This reservation is locked and cannot be modified.'); window.location='profile.php';</script>";
        exit();
    }

    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    
    if ($date < $today) {
        echo "<script>alert('Error: Selected date is in the past.');</script>";
    } else {
        mysqli_query($conn, "UPDATE reservations SET reserve_date='$date', message='$msg' WHERE id=$id");
        header("Location: profile.php");
    }
}
?>

<div class="container d-flex justify-content-center my-5">
    <div class="card p-4 border-secondary" style="width: 500px;">
        <h3 class="text-white mb-4">Modify Request</h3>
        
        <?php if ($is_locked): ?>
            <div class="alert alert-warning border-warning bg-dark text-warning">
                <i class="fas fa-lock me-2"></i> This request is <strong><?php echo $row['status']; ?></strong> or the date has passed. It can no longer be edited.
            </div>
            <a href="profile.php" class="btn btn-outline-light w-100">Back to Dashboard</a>
        <?php else: ?>
            <form method="post">
                <div class="mb-3">
                    <label class="text-white-50">New Viewing Date</label>
                    <input type="date" name="date" class="form-control" value="<?php echo $row['reserve_date']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="text-white-50">Message</label>
                    <textarea name="message" class="form-control" rows="3"><?php echo htmlspecialchars($row['message']); ?></textarea>
                </div>
                <button type="submit" name="update" class="btn btn-gold w-100">Update Details</button>
            </form>
        <?php endif; ?>
    </div>
</div>