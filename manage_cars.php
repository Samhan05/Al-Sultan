<?php 
include('config.php');
include('header.php');
if ($_SESSION['role'] != 'Admin') header("Location: login.php");
$result = mysqli_query($conn, "SELECT * FROM cars");
?>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4"><h2>Inventory</h2><a href="add_car.php" class="btn btn-gold">Add New Car</a></div>
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle">
            <thead><tr><th>Image</th><th>Make & Model</th><th>Price</th><th>Actions</th></tr></thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><img src="uploads/<?php echo $row['image']; ?>" width="60" class="rounded"></td>
                    <td><div class="fw-bold text-warning"><?php echo $row['make']; ?></div><?php echo $row['model']; ?></td>
                    <td>$<?php echo number_format($row['price']); ?></td>
                    <td>
                        <a href="edit_car.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-info">Edit</a>
                        <a href="delete_car.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include('footer.php'); ?>