<?php
include 'layout/header.php';
require_once 'models/Event.php';
require_once 'config/db.php';

if (!isset($_GET['id'])) {
    header("Location: /event-management-system/");
    exit;
}

$eventModel = new Event($pdo);
$event = $eventModel->getEventById($_GET['id']);

if (!$event) {
    die("Event not found.");
}
?>
<div class="container mt-5">
    <h2><?= htmlspecialchars($event['name']) ?></h2>
    <p><strong>Date:</strong> <?= $event['date'] ?></p>
    <p><strong>Time:</strong> <?= $event['time'] ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
    <p><strong>Capacity:</strong> <?= $event['max_capacity'] ?></p>
    <p><strong>Description:</strong> <?= htmlspecialchars($event['description']) ?></p>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="POST" action="/event-management-system/attendee-register">
            <input type="hidden" name="event_id" value="<?= $_GET['id'] ?>">
            <button type="submit" class="btn btn-primary">Register for Event</button>
        </form>
    <?php else: ?>
        <p><a href="/event-management-system/login" class="btn btn-warning">Login to Register</a></p>
    <?php endif; ?>
</div>
<?php include 'layout/footer.php'; ?>
