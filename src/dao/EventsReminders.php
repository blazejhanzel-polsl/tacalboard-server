<?php


class EventsReminders {
    private int $id;
    private int $event_id;
    private string $reminder_date;

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
