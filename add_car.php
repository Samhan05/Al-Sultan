<?php 
include('config.php');
include('header.php');

if(isset($_POST['add'])) {
    $make = $_POST['make']; $model = $_POST['model']; $year = $_POST['year'];
    $price = $_POST['price']; $desc = $_POST['description']; $specs = $_POST['specs'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    
    $sql = "INSERT INTO cars (make, model, year, price, description, specs, image) VALUES ('$make', '$model', '$year', '$price', '$desc', '$specs', '$image')";
    mysqli_query($conn, $sql);
    header("Location: manage_cars.php");
}
?>
<div class="container my-5"><div class="row justify-content-center"><div class="col-md-8"><div class="card p-4">
    <h3 class="mb-4">Add To Fleet</h3>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="make" class="form-control mb-3" placeholder="Make" required>
        <input type="text" name="model" class="form-control mb-3" placeholder="Model" required>
        <input type="number" name="year" class="form-control mb-3" placeholder="Year" required>
        <input type="number" name="price" class="form-control mb-3" placeholder="Price" required>
        <input type="text" name="specs" class="form-control mb-3" placeholder="Specs (e.g. V12, 700HP)">
        <textarea name="description" class="form-control mb-3" placeholder="Description" rows="3"></textarea>
        <input type="file" name="image" class="form-control mb-4" required>
        <button type="submit" name="add" class="btn btn-gold w-100">Add Vehicle</button>
    </form>
</div></div></div></div>
<?php include('footer.php'); ?>