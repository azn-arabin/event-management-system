<?php
require_once __DIR__ . '/../config/db.php';

class Event {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createEvent($user_id, $name, $description, $date, $time, $location, $max_capacity) {
        $stmt = $this->pdo->prepare("INSERT INTO events (user_id, name, description, date, time, location, max_capacity) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$user_id, $name, $description, $date, $time, $location, $max_capacity]);
    }

    public function getAllEvents() {
        $stmt = $this->pdo->query("SELECT * FROM events ORDER BY date ASC");
        return $stmt->fetchAll();
    }

    public function getEventById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateEvent($id, $name, $description, $date, $time, $location, $max_capacity) {
        $stmt = $this->pdo->prepare("UPDATE events SET name=?, description=?, date=?, time=?, location=?, max_capacity=? WHERE id=?");
        return $stmt->execute([$name, $description, $date, $time, $location, $max_capacity, $id]);
    }

    public function deleteEvent($id) {
        $stmt = $this->pdo->prepare("DELETE FROM events WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Fetch all events with attendee count
    public function getAllEventsWithAttendeeCount() {
        $stmt = $this->pdo->query("
            SELECT e.id, e.name, e.date, e.time, e.location, e.max_capacity, 
                   COUNT(a.id) as attendee_count
            FROM events e
            LEFT JOIN attendees a ON e.id = a.event_id
            GROUP BY e.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get attendees for a specific event
    public function getEventAttendees($eventId) {
        $stmt = $this->pdo->prepare("
            SELECT u.id, u.name, u.email, a.registered_at
            FROM attendees a
            JOIN users u ON a.user_id = u.id
            WHERE a.event_id = ?
        ");
        $stmt->execute([$eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
