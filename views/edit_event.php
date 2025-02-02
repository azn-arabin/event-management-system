<?php
include 'layout/header.php';
require_once 'models/Event.php';
require_once 'config/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: my-events.php");
    exit;
}

$eventModel = new Event($pdo);
$event = $eventModel->getEventById($_GET['id']);

if (!$event) {
    die("Event not found.");
}
?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
   <div class="card shadow-lg p-4 rounded" style="max-width: 400px; width: 100%; background: #f3f3f3;">
       <h2 class="text-center mb-4">Edit Event</h2>
       <?php if (isset($_SESSION['error'])): ?>
           <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
       <?php endif; ?>
       <form method="POST" action="/event-management-system/edit-event">
           <div class="mb-3">
               <input type="hidden" name="id" value="<?= $event['id'] ?>">
           </div>
           <div class="mb-3">
               <input type="text" name="name" value="<?= htmlspecialchars($event['name']) ?>" class="form-control mb-2">
           </div>
           <div class="mb-3">
               <textarea name="description" class="form-control mb-2"><?= htmlspecialchars($event['description']) ?></textarea>
           </div>
           <div class="mb-3">
               <input type="date" name="date" value="<?= $event['date'] ?>" class="form-control mb-2">
           </div>
           <div class="mb-3">
               <input type="time" name="time" value="<?= $event['time'] ?>" class="form-control mb-2">
           </div>
           <div class="mb-3">
               <input type="text" name="location" value="<?= htmlspecialchars($event['location']) ?>" class="form-control mb-2">
           </div>
           <div class="mb-3">
               <input type="number" name="max_capacity" value="<?= $event['max_capacity'] ?>" class="form-control mb-2">
           </div>
           <button type="submit" class="btn btn-primary w-100">Update Event</button>
       </form>
   </div>
</div>
<?php include 'layout/footer.php'; ?>
