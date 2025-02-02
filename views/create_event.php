<?php include 'layout/header.php'; ?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4 rounded" style="max-width: 400px; width: 100%; background: #f3f3f3;">
        <h2 class="text-center mb-4">Create Event</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <form method="POST" action="/event-management-system/create-event">
            <div class="mb-3">
                <input type="text" name="name" class="form-control mb-2" placeholder="Event Name" required>
            </div>
            <div class="mb-3">
                <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
            </div>
            <div class="mb-3">
                <input type="date" name="date" class="form-control mb-2">
            </div>
            <div class="mb-3">
                <input type="time" name="time" class="form-control mb-2">
            </div>
            <div class="mb-3">
                <input type="text" name="location" class="form-control mb-2" placeholder="Location">
            </div>
            <div class="mb-3">
                <input type="number" name="max_capacity" class="form-control mb-2" placeholder="Max Attendees">
            </div>
            <button type="submit" class="btn btn-primary w-100">Create Event</button>
        </form>
    </div>
</div>
<?php include 'layout/footer.php'; ?>
