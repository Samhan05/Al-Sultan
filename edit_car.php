<?php 
include('config.php');


session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM cars WHERE id=$id");
$car = mysqli_fetch_assoc($result);


if(isset($_POST['update'])) {
  
    $make = mysqli_real_escape_string($conn, $_POST['make']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $specs = mysqli_real_escape_string($conn, $_POST['specs']);
    

    $image = $car['image'];
    

    if($_FILES['image']['name'] != "") {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    }
    
    $sql = "UPDATE cars SET 
            make='$make', 
            model='$model', 
            year='$year', 
            price='$price', 
            description='$desc', 
            specs='$specs', 
            image='$image' 
            WHERE id=$id";
            
    if (!mysqli_query($conn, $sql)) {
        echo "Error updating record: " . mysqli_error($conn);
    } else {
        header("Location: manage_cars.php");
        exit();
    }
}


include('header.php');
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h3 class="mb-4 text-warning">Edit Vehicle</h3>
                
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Make</label>
                            <input type="text" name="make" class="form-control" value="<?php echo $car['make']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Model</label>
                            <input type="text" name="model" class="form-control" value="<?php echo $car['model']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Year</label>
                            <input type="number" name="year" class="form-control" value="<?php echo $car['year']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control" value="<?php echo $car['price']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Specs</label>
                        <input type="text" name="specs" class="form-control" value="<?php echo $car['specs']; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3"><?php echo $car['description']; ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label>Current Image</label><br>
                        <img src="uploads/<?php echo $car['image']; ?>" width="150" class="rounded mb-2 border border-secondary">
                    </div>

                    <div class="mb-4">
                        <label>New Image (Leave empty to keep current)</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" name="update" class="btn btn-gold flex-grow-1">Update Vehicle</button>
                        <a href="manage_cars.php" class="btn btn-outline-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>