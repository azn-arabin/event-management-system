<?php
require_once __DIR__ . '/../config/db.php';

class EventReport {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fetch attendees for an event
    public function getAttendeesByEvent($event_id) {
        $stmt = $this->pdo->prepare("SELECT attendees.id, attendees.name, attendees.email FROM attendees WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Log report download
    public function logDownload($admin_id, $event_id) {
        $stmt = $this->pdo->prepare("INSERT INTO event_reports (admin_id, event_id, download_time) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $admin_id, $event_id);
        return $stmt->execute();
    }
}
?>
