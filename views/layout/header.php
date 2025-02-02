<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Event Management System' ?></title>
    <link rel="stylesheet" href="/event-management-system/public/css/bootstrap.min.css"> <!-- Fixed Path -->
    <?php if (isset($styles)) echo $styles; ?>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/event-management-system/">Event Manager</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] == 'user'): ?>
                        <li class="nav-item"><a class="nav-link" href="/event-management-system">All Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="/event-management-system/my-events">My Events</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="/event-management-system/logout">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/event-management-system/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/event-management-system/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main style="min-height: 100vh; padding-top: 40px;">
