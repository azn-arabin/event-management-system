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
$attendees = $eventModel->getEventAttendees($_GET['id']);

if (!$event) {
    die("Event not found.");
}
?>

<!-- ✅ Full-width background section -->
<div class="event-banner text-center" style="background: #007bff; color: white; padding: 40px 20px; min-height: 250px; position: relative;">
    <div class="container">
        <h1 class="display-4"><?= htmlspecialchars($event['name']) ?></h1>
        <p class="lead"><i class="fas fa-calendar-alt"></i> <?= $event['date'] ?> | <i class="fas fa-clock"></i> <?= $event['time'] ?></p>
        <p style="position: absolute; bottom: 20px; right: 20px; font-size: 18px;">
            <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($event['location']) ?>
        </p>
    </div>
</div>

<!-- ✅ Event Description -->
<div class="container mt-4">
    <h3>Description</h3>
    <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>

    <!-- ✅ Registered Users -->
    <h3 class="mt-5">Registered Attendees</h3>
    <div class="row">
        <?php if (empty($attendees)) { ?>
            <p class="ml-3">No attendees registered yet.</p>
        <?php } else { ?>
            <?php foreach ($attendees as $attendee) { ?>
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-center bg-light p-3 rounded">
                        <div class="profile-placeholder text-white bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; font-size: 24px;">
                            <?= strtoupper($attendee['name'][0]) ?>
                        </div>
                        <div class="ml-3">
                            <h5 class="mb-0"><?= htmlspecialchars($attendee['name']) ?></h5>
                            <small><?= htmlspecialchars($attendee['email']) ?></small>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <!-- ✅ Register Button -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/event-management-system/attendee-register?event_id=<?= $_GET['id'] ?>" class="btn btn-primary mt-3">Register for this Event</a>
    <?php else: ?>
        <p><a href="/event-management-system/login" class="btn btn-warning mt-3">Login to Register</a></p>
    <?php endif; ?>
</div>

<?php include 'layout/footer.php'; ?>
