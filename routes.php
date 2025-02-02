<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/EventController.php';
require_once __DIR__ . '/controllers/AttendeeController.php';

$authController = new AuthController($pdo);
$eventController = new EventController($pdo);
$attendeeController = new AttendeeController($pdo);

$request = $_GET['url'] ?? 'index';

// ✅ Handle POST Requests (Form Submissions)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($request) {
        case 'register':
            $authController->register();
            break;
        case 'login':
            $authController->login();
            break;
        case 'create-event':
            $eventController->createEvent();
            break;
        case 'edit-event':
            $eventController->editEvent();
            break;
        default:
            header("Location: /event-management-system/");
            exit;
    }
    exit;
}

// ✅ Handle GET Requests (Page Views)
switch ($request) {
    case 'register':
        require 'views/register.php';
        break;
    case 'login':
        require 'views/login.php';
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'my-events':
        require 'views/my-events.php';
        break;
    case 'create-event':
        require 'views/create_event.php';
        break;
    case 'edit-event':
        require 'views/edit_event.php';
        break;
    case 'delete-event':
        $eventController->deleteEvent();
        break;
    case 'event-details':
        require 'views/event_details.php';
        break;
    case 'attendee-register':
        $attendeeController->register();
        break;
    case 'event-report':
        require 'views/event_report.php';
        break;
    case 'event-report-download':
        $eventController->downloadEventAttendees();
        break;
    default:
        require 'views/index.php';
        break;
}
