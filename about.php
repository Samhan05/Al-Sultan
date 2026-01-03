<?php 

include('config.php');
include('header.php'); 


$sold_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM reservations WHERE status='Approved'");
$sold_count = mysqli_fetch_assoc($sold_query)['total'];

$users_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='Customer'");
$users_count = mysqli_fetch_assoc($users_query)['total'];
?>

<header class="page-header" style="background-image: url('uploads/showroom.png');">
    <div class="page-overlay"></div>
    <div class="header-content container animate__animated animate__fadeIn">
        <h1 class="display-3 fw-bold text-uppercase">Our Legacy</h1>
        <div style="width: 80px; height: 4px; background: var(--gold); margin: 20px auto;"></div>
        <p class="lead fs-4">Redefining the standard of luxury automotive since 2005.</p>
    </div>
</header>

<section class="container my-5 py-5">
    <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0 animate__animated animate__fadeInLeft">
            <h2 class="mb-4 text-white">Driven by <span class="text-warning">Perfection</span></h2>
            <p class="text-white-50 fs-5 mb-4">
                At Al-Sultan, we don't just sell cars; we curate experiences. Our journey began with a simple belief: 
                that the acquisition of a luxury vehicle should be as exceptional as the machine itself.
            </p>
            <p class="text-white-50">
                With a global network of collectors and manufacturers, we source only the finest examples of automotive engineering. 
                Each vehicle in our showroom tells a story of heritage, performance, and uncompromising quality.
            </p>
            <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=1966" class="img-fluid rounded shadow-lg mt-4" alt="Showroom Interior">
        </div>

        <div class="col-lg-5 offset-lg-1 animate__animated animate__fadeInRight">
            <div class="card p-4 shadow-lg border-secondary">
                <div class="card-body">
                    <h3 class="h4 mb-4 text-warning">The Royale Numbers</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-center">
                            <span class="text-warning h5 me-3">✓</span> 
                            <span class="text-white">
                                <strong class="text-warning"><?php echo number_format($sold_count); ?></strong> 
                                Exclusive Vehicles Delivered
                            </span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <span class="text-warning h5 me-3">✓</span> 
                            <span class="text-white">
                                <strong class="text-warning"><?php echo number_format($users_count); ?></strong> 
                                Global Club Members
                            </span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <span class="text-warning h5 me-3">✓</span> 
                            <span class="text-white">Lifetime Service Support</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <span class="text-warning h5 me-3">✓</span> 
                            <span class="text-white">150-Point Certified Inspection</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-black py-5">
    <div class="container text-center">
        <h2 class="mb-5 text-white">Meet the Visionary</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 col-lg-3">
                <div class="team-member animate__animated animate__fadeInUp">
                    <img src="uploads/sultan.jpeg" class="rounded-circle mb-3 shadow" alt="CEO" 
                         style="border: 2px solid var(--gold); padding: 5px; width: 180px; height: 180px; object-fit: cover;">
                    <h5 class="text-white mt-3">Sultan Samhan</h5>
                    <p class="text-warning small text-uppercase letter-spacing-2">Founder & CEO</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>