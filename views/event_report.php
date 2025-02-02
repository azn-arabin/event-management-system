<?php
include 'layout/header.php';
require_once 'models/Event.php';
require_once 'config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login");
    exit;
}

$eventModel = new Event($pdo);
$events = $eventModel->getAllEventsWithAttendeeCount();
?>
<div class="container mt-5">
    <h2>Event Reports</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Number of Attendees</th>
            <th>Capacity</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($events as $event) { ?>
            <tr>
                <td><?= htmlspecialchars($event['name']) ?></td>
                <td><?= $event['date'] ?></td>
                <td><?= $event['time'] ?></td>
                <td><?= htmlspecialchars($event['location']) ?></td>
                <td><?= $event['attendee_count'] ?></td>
                <td><?= $event['max_capacity'] ?></td>
                <td>
                    <a href="/event-management-system/event-report-download?id=<?= $event['id'] ?>" class="btn btn-success btn-sm">
                        Download CSV
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'layout/footer.php'; ?>
