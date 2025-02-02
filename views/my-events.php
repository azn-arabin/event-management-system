<?php
include 'layout/header.php';
require_once 'models/Event.php';
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'user') {
    header("Location: event-report");
    exit;
}

$eventModel = new Event($pdo);
$userId = $_SESSION['user_id'];

// ✅ Pagination & Filtering
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) && in_array($_GET['sort'], ['name', 'date', 'time', 'location']) ? $_GET['sort'] . ' ASC' : 'date ASC, time ASC';

$events = $eventModel->getMyEventsWithAttendeeCount($userId, $limit, $offset, $search, $sort);
$totalEvents = $eventModel->getTotalMyEvents($userId, $search);
$totalPages = ceil($totalEvents / $limit);
?>

<div class="container mt-5 d-flex flex-column gap-2">
    <div class="d-flex flex-row gap-2 align-items-center justify-content-between">
        <h2>My Events</h2>
        <a href="/event-management-system/create-event" class="btn btn-primary mb-3">Create New Event</a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="" class="mb-3 d-flex flex-row gap-2 align-items-center">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name or location" class="form-control w-25">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th><a href="?sort=name">Name</a></th>
                <th><a href="?sort=date">Date</a></th>
                <th><a href="?sort=time">Time</a></th>
                <th><a href="?sort=location">Location</a></th>
                <th>Number of Attendees</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($events)) { ?>
                <tr>
                    <td colspan="7">No events found</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($events as $event) { ?>
                    <tr>
                        <td><?= htmlspecialchars($event['name']) ?></td>
                        <td><?= $event['date'] ?></td>
                        <td><?= $event['time'] ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                        <td><?= $event['attendee_count'] ?></td>
                        <td><?= $event['max_capacity'] ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?= $event['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $event['id'] ?>">
                                    <a class="dropdown-item" href="/event-management-system/event-details?id=<?= $event['id'] ?>">Details</a>
                                    <a class="dropdown-item" href="/event-management-system/edit-event?id=<?= $event['id'] ?>">Edit</a>
                                    <a class="dropdown-item text-danger" href="/event-management-system/delete-event?id=<?= $event['id'] ?>" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav class="align-self-end">
        <ul class="pagination">
            <?php if ($page > 1) { ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Previous</a></li>
            <?php } ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                </li>
            <?php } ?>

            <?php if ($page < $totalPages) { ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Next</a></li>
            <?php } ?>
        </ul>
    </nav>
</div>

<?php include 'layout/footer.php'; ?>
