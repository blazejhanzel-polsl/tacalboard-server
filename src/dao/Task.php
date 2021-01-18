<?php
require_once __DIR__ . '/../DatabaseProvider.php';


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

    private function __construct(int $id, string $deadline_date, ?string $description, bool $done, int $duration, int $position,
                                 int $priority, ?string $reminder_date, ?int $repeating_id, int $tasks_list_id, string $title) {
        $this->setId($id);
        $this->setDeadlineDate($deadline_date);
        $this->setDescription($description);
        $this->setDone($done);
        $this->setDuration($duration);
        $this->setPosition($position);
        $this->setPriority($priority);
        $this->setReminderDate($reminder_date);
        $this->setRepeatingId($repeating_id);
        $this->setTasksListId($tasks_list_id);
        $this->setTitle($title);
    }

    public static function create(string $deadline_date, ?string $description, bool $done, int $duration, int $position,
                                  int $priority, ?string $reminder_date, ?int $repeating_id, int $tasks_list_id, string $title): Task {
        return new Task(null, $deadline_date, $description, $done, $duration, $position, $priority, $reminder_date, $repeating_id, $tasks_list_id, $title);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM tasks WHERE `id` = $id;");
    }

    public static function getAllByTasksListId(int $id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM tasks WHERE `tasks_list_id` = $id ORDER BY `position`;");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Task(
                    $row['id'],
                    $row['deadline_date'],
                    $row['description'],
                    $row['done'],
                    $row['duration'],
                    $row['position'],
                    $row['priority'],
                    $row['reminder_date'],
                    $row['repeating_id'],
                    $row['tasks_list_id'],
                    $row['title']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?Task {
        $result = DatabaseProvider::query("SELECT * FROM tasks WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Task(
                $row['id'],
                $row['deadline_date'],
                $row['description'],
                $row['done'],
                $row['duration'],
                $row['position'],
                $row['priority'],
                $row['reminder_date'],
                $row['repeating_id'],
                $row['tasks_list_id'],
                $row['title']
            );
        }
        return null;
    }

    public static function insert(Task $task): bool {
        return DatabaseProvider::query(
            "INSERT INTO tasks (`id`, `deadline_date`, `description`, `done`, `duration`, `position`, `priority`,
                   `reminder_date`, `repeating_id`, `tasks_list_id`, `title`)
                   VALUES ($task->id, '$task->deadline_date', '$task->description', '$task->done', '$task->duration',
                           $task->position, $task->priority, '$task->reminder_date', $task->repeating_id,
                           $task->tasks_list_id, '$task->title');"
        );
    }

    public static function movePosition(Task $task, int $direction): bool {
        if ($direction != 0) {
            $objs = Task::getAllByTasksListId($task->tasks_list_id);

            foreach ($objs as $obj) {
                if ($obj->position = ($task->position + $direction)) {
                    $obj->position = $task->position;
                    $task->position = $task->position + $direction;
                    try {
                        DatabaseProvider::transactionBegin();
                        Task::update($obj);
                        Task::update($task);
                        DatabaseProvider::transactionEnd();
                    } catch (Exception $e) {
                        return false;
                    }
                    return true;
                }
            }
        }
        return false;
    }

    public static function update(Task $task): bool {
        return DatabaseProvider::query(
            "UPDATE tasks SET `deadline_date` = '$task->deadline_date', `description` = '$task->description', `done` = $task->done,
                 `duration` = $task->duration, `position` = $task->position, `priority` = $task->priority,
                 `reminder_date` = '$task->reminder_date', `repeating_id` = $task->repeating_id,
                 `tasks_list_id` = $task->tasks_list_id, `title` = '$task->title' WHERE `id` = $task->id;"
        );
    }

    // Getters and setters

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
        if ($duration < 0) {
            $duration = 0;
        }
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
    public function setPriority(int $priority): bool {
        if ($priority >= 0 && $priority <= 3) {
            $this->priority = $priority;
            return true;
        }
        return false;
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
