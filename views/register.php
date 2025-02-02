<?php include 'layout/header.php';
if (isset($_SESSION['user_id'])) {
    header("Location: /event-management-system");
    exit;
}
?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4 rounded" style="max-width: 400px; width: 100%; background: #f3f3f3;">
        <h2 class="text-center mb-4">Register</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="/event-management-system/register">
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
</div>
<?php include 'layout/footer.php'; ?>
