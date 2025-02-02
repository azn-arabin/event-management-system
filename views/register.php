<?php include 'layout/header.php'; ?>
<div class="container mt-5">
    <h2>Register</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form method="POST" action="/event-management-system/register">
        <input type="text" name="name" class="form-control mb-2" placeholder="Full Name" required>
        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <input type="password" name="confirm_password" class="form-control mb-2" placeholder="Confirm Password" required>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
<?php include 'layout/footer.php'; ?>
