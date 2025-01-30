// event_script.php
<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $maxCapacity = $_POST['max_capacity'];
    $createdBy = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO events (name, description, date, time, location, max_capacity, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $date, $time, $location, $maxCapacity, $createdBy]);

    header('Location: index.php');
    exit;
}
?>