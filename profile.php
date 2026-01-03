<?php 
include('config.php');
include('header.php'); 


if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];


$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $uid"));


$res_query = mysqli_query($conn, "SELECT r.*, c.make, c.model, c.image, c.price 
                                  FROM reservations r 
                                  JOIN cars c ON r.car_id = c.id 
                                  WHERE r.user_id = $uid 
                                  ORDER BY r.id DESC");
$res_count = mysqli_num_rows($res_query);


$user_messages = mysqli_query($conn, "SELECT * FROM messages WHERE user_id = $uid ORDER BY created_at DESC");
?>

<div class="bg-dark py-5 border-bottom border-secondary">
    <div class="container">
        <div class="row align-items-center text-center text-md-start">
            <div class="col-md-2 position-relative">
                <img src="<?php echo !empty($user['avatar']) && $user['avatar'] != 'default_avatar.png' ? 'uploads/'.$user['avatar'] : 'https://ui-avatars.com/api/?name='.urlencode($user['username']).'&background=d4af37&color=fff&size=128'; ?>" 
                     class="rounded-circle border border-3 border-warning shadow" style="width:130px; height:130px; object-fit:cover;">
                <button class="btn btn-sm btn-gold position-absolute bottom-0 end-0 rounded-circle shadow" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="fas fa-camera"></i>
                </button>
            </div>
            <div class="col-md-10 mt-3 mt-md-0">
                <h6 class="text-warning text-uppercase small letter-spacing-2">Authorized Client</h6>
                <h1 class="text-white display-4 fw-bold mb-0"><?php echo htmlspecialchars($user['username']); ?></h1>
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 mt-2">
                    <p class="text-white-50 mb-0"><i class="fas fa-envelope me-2 text-warning"></i> <?php echo $user['email']; ?></p>
                    <p class="text-white-50 mb-0"><i class="fas fa-id-badge me-2 text-warning"></i> Membership Verified</p>
                </div>
                <button class="btn btn-outline-gold btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">Update Profile Settings</button>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card p-0 border-0 bg-transparent">
                <div class="list-group list-group-flush shadow-sm custom-sidebar">
                    <button class="list-group-item active" id="btn-dash">
                        <i class="fas fa-th-large me-2"></i> Overview
                    </button>
                    <button class="list-group-item bg-black text-white-50" id="btn-inbox">
                        <i class="fas fa-envelope me-2"></i> My Inbox
                    </button>
                    <a href="logout.php" class="list-group-item bg-black text-danger border-secondary">
                        <i class="fas fa-sign-out-alt me-2"></i> Sign Out
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div id="view-dashboard">
                <div class="row g-4 mb-4 text-center text-md-start">
                    <div class="col-md-6">
                        <div class="card p-4 border-secondary">
                            <h6 class="text-white-50 small text-uppercase mb-1">Total Requests</h6>
                            <h2 class="text-white mb-0"><?php echo $res_count; ?> <span class="small text-muted fw-normal">Vehicles</span></h2>
                        </div>
                    </div>
                </div>

                <div class="card border-0 bg-transparent mb-4">
                    <div class="card-header bg-dark py-3 border border-secondary border-bottom-0">
                        <h5 class="mb-0 text-white" style="font-family: 'Cinzel', serif;">My Virtual Garage</h5>
                    </div>
                    <div class="card-body border border-secondary p-4 bg-black">
                        <?php if($res_count > 0): ?>
                            <div class="row g-4">
                                <?php while($res = mysqli_fetch_assoc($res_query)): ?>
                                    <div class="col-md-6">
                                        <div class="card bg-dark border-secondary h-100 overflow-hidden car-card">
                                            <div class="position-relative">
                                                <img src="uploads/<?php echo $res['image']; ?>" class="card-img-top" style="height:180px; object-fit:cover;">
                                                <span class="badge position-absolute top-0 end-0 m-3 <?php echo $res['status'] == 'Approved' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                                    <?php echo $res['status'] ? $res['status'] : 'Pending'; ?>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-warning text-uppercase small mb-1"><?php echo $res['make']; ?></h6>
                                                <h5 class="text-white fw-bold"><?php echo $res['model']; ?></h5>
                                                <p class="text-white-50 small mb-3"><i class="far fa-calendar-alt me-2"></i>Requested: <?php echo $res['reserve_date']; ?></p>
                                                <div class="d-flex gap-2">
                                                    <a href="car_details.php?id=<?php echo $res['car_id']; ?>" class="btn btn-sm btn-outline-gold flex-grow-1">View Info</a>
                                                    <a href="edit_reservation.php?id=<?php echo $res['id']; ?>" class="btn btn-sm btn-outline-light"><i class="fas fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="display-1 text-muted opacity-25 mb-3"><i class="fas fa-car"></i></div>
                                <h3 class="text-white">Your garage is empty.</h3>
                                <p class="text-white-50">You haven't requested any vehicles yet.</p>
                                <a href="showroom.php" class="btn btn-gold mt-3">Browse Inventory</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div id="view-inbox" class="d-none">
                <div class="card border-0 bg-transparent mb-4">
                    <div class="card-header bg-dark py-3 border border-secondary border-bottom-0">
                        <h5 class="mb-0 text-white" style="font-family: 'Cinzel', serif;">Message History</h5>
                    </div>
                    <div class="card-body border border-secondary p-4 bg-black">
                        <?php if(mysqli_num_rows($user_messages) > 0): ?>
                            <?php while($msg = mysqli_fetch_assoc($user_messages)): ?>
                                <div class="card bg-dark border-secondary mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-warning small text-uppercase fw-bold">My Inquiry</span>
                                            <span class="text-muted small"><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></span>
                                        </div>
                                        <p class="text-white mb-3"><?php echo htmlspecialchars($msg['message']); ?></p>
                                        
                                        <?php if(!empty($msg['reply'])): ?>
                                            <div class="p-3 rounded bg-black border-start border-warning border-4">
                                                <h6 class="text-warning mb-1"><i class="fas fa-crown me-2"></i> Al-Sultan Concierge</h6>
                                                <p class="text-white-50 mb-0"><?php echo nl2br(htmlspecialchars($msg['reply'])); ?></p>
                                                <small class="text-muted d-block mt-2"><?php echo date('M d, Y', strtotime($msg['replied_at'])); ?></small>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-muted small italic"><i class="fas fa-clock me-2"></i>Waiting for response...</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <p class="text-white-50">You haven't sent any messages yet.</p>
                                <a href="contact.php" class="text-warning">Start a conversation</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-warning">Profile Settings</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Change Profile Picture</label>
                        <input type="file" name="avatar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="submit" class="btn btn-gold w-100">Save Profile Updates</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

const tabs = {
    'btn-dash': 'view-dashboard',
    'btn-inbox': 'view-inbox'
};

Object.keys(tabs).forEach(btnId => {
    const btn = document.getElementById(btnId);
    if(btn) {
        btn.addEventListener('click', function() {
         
            Object.values(tabs).forEach(viewId => document.getElementById(viewId).classList.add('d-none'));
           
            Object.keys(tabs).forEach(bId => {
                const b = document.getElementById(bId);
                b.classList.remove('active', 'text-warning');
                b.classList.add('bg-black', 'text-white-50');
            });
            
          
            document.getElementById(tabs[btnId]).classList.remove('d-none');
            this.classList.add('active', 'text-warning');
            this.classList.remove('bg-black', 'text-white-50');
        });
    }
});
</script>

<style>

.custom-sidebar .list-group-item {
    transition: all 0.3s ease;
    border-left: 0 !important;
    border-right: 0 !important;
    cursor: pointer;
}
.custom-sidebar .list-group-item:hover:not(.active) {
    background-color: rgba(212, 175, 55, 0.1) !important;
    color: var(--gold) !important;
    padding-left: 1.8rem;
}
.custom-sidebar .list-group-item.active {
    background-color: var(--gold) !important;
    color: #000 !important;
    border-color: var(--gold) !important;
    font-weight: 700;
}
.car-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.5);
    border-color: var(--gold) !important;
}
</style>

<?php include('footer.php'); ?>