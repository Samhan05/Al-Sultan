<?php 
include('config.php');
include('header.php');


if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}
if (isset($_POST['send_reply'])) {
    $msg_id = (int)$_POST['msg_id'];
    $reply_text = mysqli_real_escape_string($conn, $_POST['reply_text']);
    
    $update_query = "UPDATE messages SET reply = '$reply_text', is_read = 1, replied_at = NOW() WHERE id = $msg_id";
    mysqli_query($conn, $update_query);
    echo "<script>alert('Reply sent to client'); window.location='admin_dashboard.php';</script> ";
}

$cars_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM cars"))['c'];
$sold_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM reservations WHERE status='Approved'"))['total'];

$msg_total_query = mysqli_query($conn, "SELECT COUNT(*) as c FROM messages WHERE is_read=0");
$msg_total = ($msg_total_query) ? mysqli_fetch_assoc($msg_total_query)['c'] : 0;


$inventory = mysqli_query($conn, "SELECT * FROM cars ORDER BY id DESC");
$messages = mysqli_query($conn, "SELECT * FROM messages ORDER BY created_at DESC LIMIT 10");


$reservations = mysqli_query($conn, "SELECT r.*, u.username, c.make, c.model, c.image 
                                     FROM reservations r 
                                     JOIN users u ON r.user_id = u.id 
                                     JOIN cars c ON r.car_id = c.id 
                                     ORDER BY r.id DESC");
?>

<div class="bg-dark py-5 border-bottom border-secondary mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-2">
                <img src="https://ui-avatars.com/api/?name=Admin&background=d4af37&color=fff&size=128" class="rounded-circle border border-3 border-warning shadow">
            </div>
            <div class="col-md-10 mt-3 mt-md-0">
                <h6 class="text-warning text-uppercase small letter-spacing-2">System Administrator</h6>
                <h1 class="text-white display-4 fw-bold mb-0">Control Panel</h1>
                <p class="text-white-50 mt-2">Managing Al-Sultan Motorcars Operations</p>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card p-0 border-0 bg-transparent">
                <div class="list-group list-group-flush shadow-sm custom-sidebar">
                    <button class="list-group-item active" id="btn-stats"><i class="fas fa-chart-pie me-2"></i> Overview</button>
                    <button class="list-group-item bg-black text-white-50" id="btn-cars"><i class="fas fa-car me-2"></i> Manage Fleet</button>
                    <button class="list-group-item bg-black text-white-50" id="btn-msgs"><i class="fas fa-envelope me-2"></i> Inbox (<?php echo $msg_total; ?>)</button>
                    <a href="logout.php" class="list-group-item bg-black text-danger"><i class="fas fa-power-off me-2"></i> Sign Out</a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div id="view-stats">
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card p-4 border-secondary text-center">
                            <h6 class="text-white-50 small text-uppercase">Total Fleet</h6>
                            <h2 class="text-white"><?php echo $cars_total; ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-4 border-secondary text-center">
                            <h6 class="text-white-50 small text-uppercase">Cars Sold</h6>
                            <h2 class="text-success"><?php echo $sold_total; ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-4 border-secondary text-center">
                            <h6 class="text-white-50 small text-uppercase">New Messages</h6>
                            <h2 class="text-warning"><?php echo $msg_total; ?></h2>
                        </div>
                    </div>
                </div>
                
                <div class="card border-secondary bg-transparent">
                    <div class="card-header bg-dark border-secondary">
                        <h5 class="text-white mb-0">Recent Reservations</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Client</th>
                                    <th>Car</th>
                                    <th>Requested Date</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($r = mysqli_fetch_assoc($reservations)): ?>
                                    <?php 
                                        $status = !empty($r['status']) ? $r['status'] : 'Pending';
                                        $badge_class = match($status) {
                                            'Approved' => 'bg-success',
                                            'Rejected' => 'bg-danger',
                                            'Pending'  => 'bg-warning text-dark',
                                            default    => 'bg-secondary'
                                        };
                                 
                                        $carImage = isset($r['image']) ? trim($r['image']) : ''; 
                                    ?>
                                    <tr class="align-middle border-bottom border-secondary">
                                        <td class="text-white fw-bold ps-4">
                                            <?php echo htmlspecialchars($r['username']); ?>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if(!empty($carImage)): ?>
                                                    <img src="uploads/<?php echo $carImage; ?>" 
                                                         class="rounded me-3 shadow-sm" 
                                                         style="width: 80px; height: 50px; object-fit: cover; border: 1px solid #333;"
                                                         alt="Vehicle">
                                                <?php else: ?>
                                                    <div class="rounded me-3 bg-secondary d-flex align-items-center justify-content-center" style="width: 80px; height: 50px; border: 1px solid #333;">
                                                        <i class="fas fa-car text-dark"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="text-white small">
                                                    <span class="text-white d-block fw-bold"><?php echo htmlspecialchars($r['make'] . ' ' . $r['model']); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-white-50">
                                            <i class="far fa-calendar-alt me-2 text-warning small"></i>
                                            <?php echo date('M d, Y', strtotime($r['reserve_date'])); ?>
                                        </td>
                                        <td>
                                            <span class="badge <?php echo $badge_class; ?> px-3 py-2">
                                                <?php echo $status; ?>
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <?php if($status == 'Pending'): ?>
                                                <div class="btn-group">
                                                    <a href="update_reservation_status.php?id=<?php echo $r['id']; ?>&status=Approved" 
                                                       class="btn btn-sm btn-gold px-3 py-2">
                                                       <i class="fas fa-check me-1"></i> ACCEPT
                                                    </a>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted small">
                                                    <i class="fas fa-lock me-2"></i> Processed
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="view-cars" class="d-none">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-white">Fleet Management</h3>
                    <a href="add_car.php" class="btn btn-gold btn-sm">Add New Vehicle</a>
                </div>
                <div class="row g-3">
                    <?php while($c = mysqli_fetch_assoc($inventory)): ?>
                        <div class="col-md-6">
                            <div class="card bg-dark border-secondary h-100 overflow-hidden car-card">
                                <img src="uploads/<?php echo $c['image']; ?>" class="card-img-top" style="height:150px; object-fit:cover;">
                                <div class="card-body">
                                    <h6 class="text-warning mb-1"><?php echo $c['make']; ?></h6>
                                    <h5 class="text-white"><?php echo $c['model']; ?></h5>
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="edit_car.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-gold flex-grow-1">Edit Details</a>
                                        <a href="delete_car.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this car?')"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div id="view-msgs" class="d-none">
    <h3 class="text-white mb-4">Client Inquiries</h3>
    <?php while($m = mysqli_fetch_assoc($messages)): ?>
        <div class="card border-secondary bg-dark mb-3 p-3">
            <div class="d-flex justify-content-between">
                <h6 class="text-warning"><?php echo htmlspecialchars($m['name']); ?> <small class="text-white-50 ms-2"><?php echo htmlspecialchars($m['email']); ?></small></h6>
                <span class="small text-muted"><?php echo $m['created_at']; ?></span>
            </div>
            <p class="text-white mb-2 mt-2"><?php echo nl2br(htmlspecialchars($m['message'])); ?></p>
            
            <?php if(!empty($m['reply'])): ?>
                <div class="p-2 mt-2 rounded bg-black border-start border-warning border-3">
                    <small class="text-warning d-block">Your Reply:</small>
                    <p class="text-white-50 small mb-0"><?php echo $m['reply']; ?></p>
                </div>
            <?php else: ?>
                <form method="POST" class="mt-3">
                    <input type="hidden" name="msg_id" value="<?php echo $m['id']; ?>">
                    <textarea name="reply_text" class="form-control bg-black mb-2" placeholder="Type your response..." required></textarea>
                    <button type="submit" name="send_reply" class="btn btn-gold btn-sm">Send Reply</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>
        </div>
    </div>
</div>

<script>

const tabs = {
    'btn-stats': 'view-stats',
    'btn-cars': 'view-cars',
    'btn-msgs': 'view-msgs'
};

Object.keys(tabs).forEach(btnId => {
    document.getElementById(btnId).addEventListener('click', function() {
        Object.values(tabs).forEach(viewId => document.getElementById(viewId).classList.add('d-none'));
        Object.keys(tabs).forEach(bId => document.getElementById(bId).classList.remove('active', 'text-warning'));
        document.getElementById(tabs[btnId]).classList.remove('d-none');
        this.classList.add('active', 'text-warning');
    });
});
</script>

<style>

.custom-sidebar .list-group-item {
    transition: all 0.3s ease;
    cursor: pointer;
    border-color: #333 !important;
}
.custom-sidebar .list-group-item:hover:not(.active) {
    background-color: rgba(212, 175, 55, 0.1) !important;
    color: var(--gold) !important;
    padding-left: 1.5rem;
}
.custom-sidebar .list-group-item.active {
    background-color: var(--gold) !important;
    color: #000 !important;
    border-color: var(--gold) !important;
    font-weight: bold;
}
.car-card {
    transition: transform 0.3s ease;
}
.car-card:hover {
    transform: translateY(-5px);
}
</style>

<?php include('footer.php'); ?>