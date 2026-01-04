<?php 
include('config.php');
include('header.php'); 

$status_msg = "";

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "NULL";

    $sql = "INSERT INTO messages (user_id, name, email, subject, message) 
            VALUES ($user_id, '$name', '$email', '$subject', '$message')";
    
    if(mysqli_query($conn, $sql)) {
        $status_msg = "Your inquiry has been sent to our concierge. We will respond shortly.";
    } else {
        $status_msg = "Error: Could not send message. Please try again later.";
    }
}
?>

<div class="container my-5 py-5">
    <div class="text-center mb-5 animate__animated animate__fadeIn">
        <h1 class="text-white display-5 fw-bold">Connect With Us</h1>
        <p class="text-white-50">Private consultations available by appointment</p>
        <div style="width: 60px; height: 2px; background: var(--gold); margin: 20px auto;"></div>
    </div>

    <div class="row g-5">
        <div class="col-lg-5">
            <div class="card p-4 h-100 shadow-lg border-secondary" style="background: rgba(20,20,20,0.8) !important;">
                <h3 class="text-white mb-4">Visit Our Showroom</h3>
                
                <div class="d-flex mb-4">
                    <div class="text-warning h4 me-3"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h6 class="text-white text-uppercase small">Address</h6>
                        <p class="text-white-50 small mb-0">Al-Madina St, Amman, Jordan</p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="text-warning h4 me-3"><i class="fas fa-phone-alt"></i></div>
                    <div>
                        <h6 class="text-white text-uppercase small">Direct Line</h6>
                        <p class="text-white-50 small mb-0">+962 79 8555 066</p>
                    </div>
                </div>

                <div class="mt-4 p-3 border border-secondary rounded">
                    <h6 class="text-white mb-2 small text-uppercase">Opening Hours</h6>
                    <ul class="list-unstyled text-white-50 small mb-0">
                        <li class="d-flex justify-content-between"><span>Sun - Thu:</span> <span>9:00 - 20:00</span></li>
                        <li class="d-flex justify-content-between"><span>Fri - Sat:</span> <span>By Appointment</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <?php if(!empty($status_msg)): ?>
                <div class="alert alert-success bg-dark border-success text-success animate__animated animate__fadeIn mb-4">
                    <i class="fas fa-check-circle me-2"></i> <?php echo $status_msg; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="animate__animated animate__fadeInRight">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control py-3" placeholder="Full Name" required>
                    </div>
                    <div class="col-md-6">
                        <input type="email" name="email" class="form-control py-3" placeholder="Email Address" required>
                    </div>
                    <div class="col-12">
                        <input type="text" name="subject" class="form-control py-3" placeholder="Inquiry Subject" required>
                    </div>
                    <div class="col-12">
                        <textarea name="message" class="form-control" placeholder="How can we assist you today?" style="height: 180px" required></textarea>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" name="submit" class="btn btn-gold w-100 py-3">Send Inquiry</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
