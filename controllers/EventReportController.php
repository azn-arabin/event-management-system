<?php
require_once __DIR__ . '/../models/EventReport.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class EventReportController {
    private $eventReport;

    public function __construct($db) {
        $this->eventReport = new EventReport($db);
    }

    // Display the report view
    public function showReport($event_id) {
        $attendees = $this->eventReport->getAttendeesByEvent($event_id);
        include 'views/event_report.php';
    }

    // Generate and download CSV
    public function downloadCSV($admin_id, $event_id) {
        $attendees = $this->eventReport->getAttendeesByEvent($event_id);

        if ($attendees->num_rows > 0) {
            $filename = "event_" . $event_id . "_attendees.csv";
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            $output = fopen('php://output', 'w');
            fputcsv($output, ['ID', 'Name', 'Email']); // CSV Header

            while ($row = $attendees->fetch_assoc()) {
                fputcsv($output, [$row['id'], $row['name'], $row['email']]);
            }

            fclose($output);
            $this->eventReport->logDownload($admin_id, $event_id);
            exit;
        } else {
            echo "No attendees found for this event.";
        }
    }
}
?>
