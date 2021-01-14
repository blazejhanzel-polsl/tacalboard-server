<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class EventsReminder {
    private int $id;
    private int $event_id;
    private string $reminder_date;

    public function __construct(int $id, int $event_id, string $reminder_date) {
        $this->setId($id);
        $this->setEventId($event_id);
        $this->setReminderDate($reminder_date);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM events_reminders WHERE `id` = $id;");
    }

    public static function getAllByEventId(int $event_id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM events_reminders WHERE `event_id` = $event_id ORDER BY `reminder_date`");
        if ($result->num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new EventsReminder(
                    $row['id'],
                    $row['event_id'],
                    $row['reminder_date']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?EventsReminder {
        $result = DatabaseProvider::query("SELECT * FROM events_reminders WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new EventsReminder(
                $row['id'],
                $row['event_id'],
                $row['reminder_date']
            );
        } else {
            return null;
        }
    }

    public static function insert(EventsReminder $reminder): bool {
        return DatabaseProvider::query(
            "INSERT INTO events_reminders (`id`, `event_id`, `reminder_date`)
                    VALUES ($reminder->id, $reminder->event_id, '$reminder->reminder_date');"
        );
    }

    public static function update(EventsReminder $reminder): bool {
        return DatabaseProvider::query(
            "UPDATE events_reminders SET `event_id` = $reminder->event_id, `reminder_date` = '$reminder->reminder_date'
                    WHERE `id` = $reminder->id;"
        );
    }

    // Getters and setters

    /**
     * @return int
     */
    public function getEventId(): int {
        return $this->event_id;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getReminderDate(): string {
        return $this->reminder_date;
    }

    /**
     * @param int $event_id
     */
    public function setEventId(int $event_id): void {
        $this->event_id = $event_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param string $reminder_date
     */
    public function setReminderDate(string $reminder_date): void {
        if (preg_match('/[0-9]{1,4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $reminder_date)) {
            $this->reminder_date = $reminder_date;
        }
    else {
            throw new Exception ("Unhandled date format.");
        }
    }
}
