<?php
include 'layout/header.php';
require_once 'models/Event.php';
require_once 'config/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$eventModel = new Event($pdo);
$event = $eventModel->getEventById($_GET['id']);

if (!$event) {
    die("Event not found.");
}
?>
<div class="container mt-5">
    <h2>Edit Event</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form method="POST" action="/event-management-system/edit-event">
        <input type="hidden" name="id" value="<?= $event['id'] ?>">
        <input type="text" name="name" value="<?= htmlspecialchars($event['name']) ?>" class="form-control mb-2">
        <textarea name="description" class="form-control mb-2"><?= htmlspecialchars($event['description']) ?></textarea>
        <input type="date" name="date" value="<?= $event['date'] ?>" class="form-control mb-2">
        <input type="time" name="time" value="<?= $event['time'] ?>" class="form-control mb-2">
        <input type="text" name="location" value="<?= htmlspecialchars($event['location']) ?>" class="form-control mb-2">
        <input type="number" name="max_capacity" value="<?= $event['max_capacity'] ?>" class="form-control mb-2">
        <button type="submit" class="btn btn-success">Update Event</button>
    </form>
</div>
<?php include 'layout/footer.php'; ?>
