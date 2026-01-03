<style>
    .footer-custom {
        background-color: var(--dark-bg); 
        color: white;
        border-top: 3px solid var(--gold);
    }
    
    .footer-custom h5 {
        color: var(--gold);
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
    }
    
    .footer-custom a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .footer-custom a:hover {
        color: var(--gold);
    }
    
    .footer-custom .social-icon {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 50%;
        margin-right: 10px;
        transition: all 0.3s ease;
    }
    
    .footer-custom .social-icon:hover {
        background-color: var(--gold);
        border-color: var(--gold);
        color: white;
    }

    .footer-divider {
        border-color: rgba(255,255,255,0.1);
    }
</style>

<footer class="footer-custom py-5 mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="text-uppercase mb-3">Al-Sultan Motorcars</h5>
                <p class="small text-white-50">
                    Defining the pinnacle of automotive luxury. We provide an exclusive selection of the world's finest vehicles for the most discerning clients.
                </p>
                <div class="mt-4">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Navigation</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="index.php">Home</a></li>
                    <li class="mb-2"><a href="showroom.php">Inventory</a></li>
                    <li class="mb-2"><a href="about.php">About Us</a></li>
                    <li class="mb-2"><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5>Contact</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-warning"></i>Al-Madina St ,Amman ,Jordan</li>
                    <li class="mb-2"><i class="fas fa-phone me-2 text-warning"></i> +962 79 8555 066</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2 text-warning"></i> vip@alsultan.com</li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5>Newsletter</h5>
                <p class="small text-white-50">Subscribe for exclusive updates on new arrivals.</p>
                <form action="#" method="POST">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control bg-dark border-secondary text-white" placeholder="Email Address" aria-label="Email Address">
                        <button class="btn btn-gold" type="button">Join</button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="footer-divider my-4">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small text-white-50 mb-0"> 2025 Al-Sultan Motorcars. All Rights Reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="small text-white-50 mb-0">
                    <a href="#">Privacy Policy</a> &nbsp;|&nbsp; <a href="#">Terms of Service</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>