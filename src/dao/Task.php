<?php


class Task {
    private int $id;
    private string $deadline_date;
    private string $description;
    private bool $done;
    private int $duration;
    private int $position;
    private int $priority;
    private string $reminder_date;
    private int $repeating_id;
    private int $tasks_list_id;
    private string $title;

    /**
     * @return string
     */
    public function getDeadlineDate(): string {
        return $this->deadline_date;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getDuration(): int {
        return $this->duration;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPosition(): int {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getPriority(): int {
        return $this->priority;
    }

    /**
     * @return string
     */
    public function getReminderDate(): string {
        return $this->reminder_date;
    }

    /**
     * @return int
     */
    public function getRepeatingId(): int {
        return $this->repeating_id;
    }

    /**
     * @return int
     */
    public function getTasksListId(): int {
        return $this->tasks_list_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function isDone(): bool {
        return $this->done;
    }

    /**
     * @param string $deadline_date
     * @throws Exception
     */
    public function setDeadlineDate(string $deadline_date): void {
        if (preg_match('/[0-9]{1,4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $deadline_date)) {
            $this->deadline_date = $deadline_date;
        }
    else {
            throw new Exception ("Unhandled date format.");
        }
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * @param bool $done
     */
    public function setDone(bool $done): void {
        $this->done = $done;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void {
        $this->duration = $duration;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void {
        $this->position = $position;
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority): void {
        $this->priority = $priority;
    }

    /**
     * @param string $reminder_date
     * @throws Exception
     */
    public function setReminderDate(string $reminder_date): void {
        if (preg_match('/[0-9]{1,4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $reminder_date)) {
            $this->reminder_date = $reminder_date;
        }
    else {
            throw new Exception ("Unhandled date format.");
        }
    }

    /**
     * @param int $repeating_id
     */
    public function setRepeatingId(int $repeating_id): void {
        $this->repeating_id = $repeating_id;
    }

    /**
     * @param int $tasks_list_id
     */
    public function setTasksListId(int $tasks_list_id): void {
        $this->tasks_list_id = $tasks_list_id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }
}
