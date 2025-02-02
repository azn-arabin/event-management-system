<?php include 'layout/header.php';
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard");
    exit;
}
?>
<div class="container mt-5">
    <h2>Login</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <form method="POST" action="/event-management-system/login">
        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <button type="submit" class="btn btn-success">Login</button>
    </form>
</div>
<?php include 'layout/footer.php'; ?>
