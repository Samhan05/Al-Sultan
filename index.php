<?php 
include('config.php');
include('header.php'); 


$sql = "SELECT * FROM cars WHERE status = 'Available' AND image != '' ORDER BY id DESC LIMIT 5";
$result = mysqli_query($conn, $sql);
?>

<div id="heroCarousel" class="carousel slide carousel-fade hero-slider" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php 
        $count = 0;
        while ($row = mysqli_fetch_assoc($result)):
            $active = ($count == 0) ? 'active' : '';
        ?>
            <div class="carousel-item <?php echo $active; ?>">
                <div class="full-screen-bg" style="background-image: url('uploads/<?php echo $row['image']; ?>');"></div>
                <div class="overlay-gradient"></div>
                <div class="container h-100 d-flex align-items-center justify-content-center">
                    <div class="hero-content text-center text-white">
                        <h5 class="text-uppercase text-warning animate__animated animate__fadeInDown"><?php echo $row['make']; ?></h5>
                        <h1 class="display-1 fw-bold animate__animated animate__zoomIn"><?php echo $row['model']; ?></h1>
                        <p class="lead animate__animated animate__fadeInUp"><?php echo $row['year']; ?> Edition &bull; Luxury Fleet</p>
                        <a href="car_details.php?id=<?php echo $row['id']; ?>" class="btn btn-gold btn-lg mt-3">Explore Details</a>
                    </div>
                </div>
            </div>
        <?php $count++; endwhile; ?>
    </div>
</div>

<div class="main-content-area">
    <div class="container py-5">
        <div class="row text-center mb-5">
            <h2 class="text-white mb-3">Why Choose Royale?</h2>
            <div style="width: 50px; height: 2px; background: var(--gold); margin: 0 auto;"></div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-4 h-100 text-center border-0 bg-transparent">
                    <div class="display-4 text-warning mb-3">✦</div>
                    <h4 class="text-white">Exclusive Selection</h4>
                    <p class="text-muted">Hand-picked vehicles from the world's most prestigious manufacturers.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100 text-center border-0 bg-transparent">
                    <div class="display-4 text-warning mb-3">♛</div>
                    <h4 class="text-white">VIP Service</h4>
                    <p class="text-muted">Personalized concierge service for every step of your journey.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100 text-center border-0 bg-transparent">
                    <div class="display-4 text-warning mb-3">🛡</div>
                    <h4 class="text-white">Certified Quality</h4>
                    <p class="text-muted">Every vehicle undergoes a rigorous 150-point inspection.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>