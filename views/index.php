<?php
include 'layout/header.php';
require_once 'models/Event.php';
require_once 'config/db.php';

$eventModel = new Event($pdo);
$events = $eventModel->getAllEvents();
?>
<div class="container mt-5">
    <h2>Upcoming Events</h2>
    <?php if (empty($events)): ?>
        <div class="alert alert-info">No upcoming events at the moment.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Capacity</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event['name']) ?></td>
                    <td><?= $event['date'] ?></td>
                    <td><?= $event['time'] ?></td>
                    <td><?= htmlspecialchars($event['location']) ?></td>
                    <td><?= $event['max_capacity'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php include 'layout/footer.php'; ?>
