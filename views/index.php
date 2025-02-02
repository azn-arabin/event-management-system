<?php
include 'layout/header.php';
require_once 'models/Event.php';
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
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

$events = $eventModel->getUpcomingEventsWithAttendeeCount($userId, $limit, $offset, $search, $sort);
$totalEvents = $eventModel->getTotalUpcomingEvents($search);
$totalPages = ceil($totalEvents / $limit);
?>

<div class="container mt-5 d-flex flex-column gap-2">
    <h2>Upcoming Events</h2>

    <!-- Search Form -->
    <form method="GET" action="" class="mb-3 d-flex flex-row gap-2 align-items-center">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name or location" class="form-control w-25">
        <button type="submit" class="btn btn-primary ml-2">Search</button>
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
                    <span class="d-flex flex-row gap-2 align-items-center">
                        <a href="/event-management-system/event-details?id=<?= $event['id'] ?>" class="btn btn-info btn-sm">Details</a>

                        <a href="/event-management-system/attendee-register?event_id=<?= $event['id'] ?>"
                           class="btn btn-success ml-2 btn-sm <?= $event['user_registered'] ? 'disabled' : '' ?>">
                            <?= $event['user_registered'] ? 'Registered' : 'Register' ?>
                        </a>
                    </span>
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
