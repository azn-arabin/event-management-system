<?php
require_once __DIR__ . '/../models/Event.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class EventController {
    private $event;

    public function __construct($pdo) {
        $this->event = new Event($pdo);
    }

    public function createEvent() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_id'];
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $date = $_POST['date'];
            $time = $_POST['time'];
            $location = trim($_POST['location']);
            $max_capacity = (int) $_POST['max_capacity'];

            $errors = [];

            // ✅ Name validation (min 3 chars, max 255 chars)
            if (strlen($name) < 3 || strlen($name) > 255) {
                $errors[] = "Event name must be between 3 and 255 characters.";
            }

            // ✅ Description validation (min 10 chars, max 1000 chars)
            if (strlen($description) < 10 || strlen($description) > 1000) {
                $errors[] = "Description must be between 10 and 1000 characters.";
            }

            // ✅ Date validation (must be today or later)
            $today = date('Y-m-d');
            if ($date < $today) {
                $errors[] = "Event date cannot be in the past.";
            }

            // ✅ Time validation (if today, must be greater than current time)
            if ($date == $today) {
                $current_time = date('H:i:s');
                if ($time <= $current_time) {
                    $errors[] = "Time must be later than the current time for today's events.";
                }
            }

            // ✅ Location validation (min 3 chars, max 255 chars)
            if (strlen($location) < 3 || strlen($location) > 255) {
                $errors[] = "Location must be between 3 and 255 characters.";
            }

            // ✅ Max capacity validation (min 1, max 10,000)
            if ($max_capacity < 1 || $max_capacity > 10000) {
                $errors[] = "Max capacity must be between 1 and 10,000.";
            }

            // ✅ If validation fails, return errors
            if (!empty($errors)) {
                $_SESSION['error'] = implode("<br>", $errors);
                header("Location: /event-management-system/create-event");
                exit;
            }

            // ✅ Create event if validation passes
            if ($this->event->createEvent($user_id, $name, $description, $date, $time, $location, $max_capacity)) {
                $_SESSION['success'] = "Event created successfully!";
                header("Location: /event-management-system/dashboard");
                exit;
            }
        }
    }

    public function editEvent() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $date = $_POST['date'];
            $time = $_POST['time'];
            $location = trim($_POST['location']);
            $max_capacity = (int) $_POST['max_capacity'];

            $errors = [];

            // ✅ Validate input fields (same as createEvent)
            if (strlen($name) < 3 || strlen($name) > 255) {
                $errors[] = "Event name must be between 3 and 255 characters.";
            }
            if (strlen($description) < 10 || strlen($description) > 1000) {
                $errors[] = "Description must be between 10 and 1000 characters.";
            }
            $today = date('Y-m-d');
            if ($date < $today) {
                $errors[] = "Event date cannot be in the past.";
            }
            if ($date == $today) {
                $current_time = date('H:i:s');
                if ($time <= $current_time) {
                    $errors[] = "Time must be later than the current time for today's events.";
                }
            }
            if (strlen($location) < 3 || strlen($location) > 255) {
                $errors[] = "Location must be between 3 and 255 characters.";
            }
            if ($max_capacity < 1 || $max_capacity > 10000) {
                $errors[] = "Max capacity must be between 1 and 10,000.";
            }

            // ✅ If validation fails, return errors
            if (!empty($errors)) {
                $_SESSION['error'] = implode("<br>", $errors);
                header("Location: /event-management-system/edit-event?id=$id");
                exit;
            }

            // ✅ Update event if validation passes
            if ($this->event->updateEvent($id, $name, $description, $date, $time, $location, $max_capacity)) {
                $_SESSION['success'] = "Event updated successfully!";
                header("Location: /event-management-system/dashboard");
                exit;
            }
        }
    }


    // Generate CSV file for event attendees
    public function downloadEventAttendees() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: login.php");
            exit;
        }

        if (isset($_GET['id'])) {
            $eventId = $_GET['id'];
            $attendees = $this->event->getEventAttendees($eventId);

            if ($attendees) {
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="event_' . $eventId . '_attendees.csv"');

                $output = fopen('php://output', 'w');
                fputcsv($output, ['ID', 'Name', 'Email', 'Registered At']);

                foreach ($attendees as $attendee) {
                    fputcsv($output, $attendee);
                }
                fclose($output);
                exit;
            } else {
                echo "No attendees found for this event.";
            }
        }
    }

    public function deleteEvent() {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $this->event->deleteEvent($id);
            $_SESSION['success'] = "Event deleted successfully.";
            header("Location: /event-management-system/dashboard");
            exit;
        }
    }
}
?>
