<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Event Management System' ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">

    <!-- Additional Page Styles -->
    <?php if (isset($styles)) echo $styles; ?>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Event Manager</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="../routes.php?action=logout">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    <?php if (isset($content)) echo $content; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center p-3 mt-5">
    &copy; <?= date('Y'); ?> Event Management System. All rights reserved.
</footer>

<!-- Scripts -->
<script src="../../public/js/jquery.min.js"></script>
<script src="../../public/js/bootstrap.bundle.min.js"></script>

<?php if (isset($scripts)) echo $scripts; ?>
</body>
</html>
