<?php include 'layout/header.php'; ?>
<div class="container mt-5">
    <h2>Create Event</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form method="POST" action="/event-management-system/create-event">
        <input type="text" name="name" class="form-control mb-2" placeholder="Event Name" required>
        <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
        <input type="date" name="date" class="form-control mb-2">
        <input type="time" name="time" class="form-control mb-2">
        <input type="text" name="location" class="form-control mb-2" placeholder="Location">
        <input type="number" name="max_capacity" class="form-control mb-2" placeholder="Max Attendees">
        <button type="submit" class="btn btn-success">Create Event</button>
    </form>
</div>
<?php include 'layout/footer.php'; ?>
