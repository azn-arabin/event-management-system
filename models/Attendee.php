<?php
require_once __DIR__ . '/../config/db.php';

class Attendee {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // ✅ Check if the user is already registered
    public function isUserRegistered($event_id, $user_id): bool
    {
        $stmt = $this->pdo->prepare("SELECT id FROM attendees WHERE event_id = ? AND user_id = ?");
        $stmt->execute([$event_id, $user_id]);
        return $stmt->fetch() ? true : false;
    }

    // ✅ Check if event capacity is full
    public function isEventFull($event_id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(a.id) AS registered, e.max_capacity 
                                 FROM events e
                                 LEFT JOIN attendees a ON a.event_id = e.id 
                                 WHERE e.id = ?");
        $stmt->execute([$event_id]);

        $result = $stmt->fetch();

        // Debugging output
        var_dump($result);
        echo "<br>";
        echo "Event ID: " . $event_id . "<br>";
        echo "Registered: " . $result['registered'] . "<br>";
        echo "Max Capacity: " . $result['max_capacity'] . "<br>";

        return $result['registered'] >= $result['max_capacity'];
    }


    // ✅ Register user for an event
    public function registerUser($event_id, $user_id) {
        if ($this->isUserRegistered($event_id, $user_id)) {
            return "You are already registered for this event.";
        }

        if ($this->isEventFull($event_id)) {
            return "This event is already full.";
        }

        $stmt = $this->pdo->prepare("INSERT INTO attendees (event_id, user_id) VALUES (?, ?)");
        return $stmt->execute([$event_id, $user_id]) ? "Registration successful!" : "Failed to register.";
    }
}
?>
