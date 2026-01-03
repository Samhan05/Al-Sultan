<?php 
include('config.php');
include('header.php');

// Fetch only cars that are currently available for purchase
$query = "SELECT * FROM cars WHERE status='Available' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container my-5 py-5">
    <div class="text-center mb-5 animate__animated animate__fadeIn">
        <h1 class="display-4 text-white">The Showroom</h1>
        <p class="text-muted text-uppercase letter-spacing-2">Explore our curated collection of automotive excellence</p>
        <div style="width: 60px; height: 3px; background: var(--gold); margin: 20px auto;"></div>
    </div>

    <div class="row g-4">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg animate__animated animate__fadeInUp">
                    <img src="uploads/<?php echo $row['image']; ?>" 
                         class="card-img-top" 
                         style="height: 250px; object-fit: cover;">
                         
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-white fw-bold mb-2">
                            <?php echo htmlspecialchars($row['make'] . " " . $row['model']); ?>
                        </h5>
                        
                        <p class="card-text text-white-50 small flex-grow-1 mb-4">
                            <?php echo htmlspecialchars(substr($row['description'], 0, 110)) . '...'; ?>
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <h4 class="text-warning mb-0">$<?php echo number_format($row['price']); ?></h4>
                            <a href="car_details.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-gold px-4">View</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include('footer.php'); ?>