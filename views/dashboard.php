<?php
include 'layout/header.php';
require_once 'models/Event.php';
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$eventModel = new Event($pdo);
$events = $eventModel->getAllEvents();
?>
<div class="container mt-5">
    <h2>Dashboard</h2>
    <a href="/event-management-system/create-event" class="btn btn-primary mb-3">Create New Event</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
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
                <td><?= $event['max_capacity'] ?></td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?= $event['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $event['id'] ?>">
                            <a class="dropdown-item" href="/event-management-system/edit-event?id=<?= $event['id'] ?>">Edit</a>
                            <a class="dropdown-item text-danger" href="/event-management-system/delete-event?id=<?= $event['id'] ?>" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php include 'layout/footer.php'; ?>
