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

    public function getMyEventsWithAttendeeCount($user_id, $limit, $offset, $search, $sort = 'date ASC, time ASC') {
        $searchQuery = "%$search%";

        $sql = "
        SELECT e.*, 
               (SELECT COUNT(*) FROM attendees a WHERE a.event_id = e.id) AS attendee_count
        FROM events e
        WHERE e.user_id = ? AND (e.name LIKE ? OR e.location LIKE ?)
        ORDER BY $sort
        LIMIT $limit OFFSET $offset
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $searchQuery, $searchQuery]);

        return $stmt->fetchAll();
    }

    public function getTotalMyEvents($user_id, $search) {
        $searchQuery = "%$search%";
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM events WHERE user_id = ? AND (name LIKE ? OR location LIKE ?)");
        $stmt->execute([$user_id, $searchQuery, $searchQuery]);
        return $stmt->fetchColumn();
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

    public function getUpcomingEventsWithAttendeeCount($user_id, $limit, $offset, $search, $sort = 'date ASC, time ASC') {
        $searchQuery = "%$search%";

        // ✅ Include LIMIT and OFFSET directly in the SQL query
        $sql = "
        SELECT e.*, 
               (SELECT COUNT(*) FROM attendees a WHERE a.event_id = e.id) AS attendee_count,
               (SELECT COUNT(*) FROM attendees a WHERE a.event_id = e.id AND a.user_id = ?) AS user_registered
        FROM events e
        WHERE e.date >= CURDATE() AND (e.name LIKE ? OR e.location LIKE ?)
        ORDER BY $sort
        LIMIT $limit OFFSET $offset
    ";

        // ✅ Execute the query with only the bindable parameters
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $searchQuery, $searchQuery]);

        return $stmt->fetchAll();
    }

    public function getTotalUpcomingEvents($search) {
        $searchQuery = "%$search%";
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM events WHERE date >= CURDATE() AND (name LIKE ? OR location LIKE ?)");
        $stmt->execute([$searchQuery, $searchQuery]);
        return $stmt->fetchColumn();
    }
}
