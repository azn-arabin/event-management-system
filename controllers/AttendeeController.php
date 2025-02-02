<?php
require_once __DIR__ . '/../models/Attendee.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class AttendeeController {
    private $attendee;

    public function __construct($pdo) {
        $this->attendee = new Attendee($pdo);
    }

    public function register() {
        if (isset($_GET['event_id'])) {
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['error'] = "You must be logged in to register.";
                header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "/event-management-system/")); // ✅ Stay on the same page
                exit;
            }

            $event_id = (int) $_GET['event_id'];
            $user_id = $_SESSION['user_id'];

            $result = $this->attendee->registerUser($event_id, $user_id);

            if ($result === "Registration successful!") {
                $_SESSION['success'] = $result;
            } else {
                $_SESSION['error'] = $result;
            }

            header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "/event-management-system/")); // ✅ Stay on the same page
            exit;
        }
    }
}
?>
