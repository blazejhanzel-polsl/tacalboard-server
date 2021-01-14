<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class UsersInEvent {
    private int $id;
    private int $user_id;
    private int $event_id;
    private string $role;
    private string $present;

    public function __construct(int $id, int $user_id, int $event_id, string $role, string $present) {
        $this->setId($id);
        $this->setUserId($user_id);
        $this->setEventId($event_id);
        $this->setRole($role);
        $this->setPresent($present);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM users_in_events WHERE `id` = $id;");
    }

    public static function getAllByEventId(int $id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM users_in_events WHERE `event_id` = $id;");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new UsersInEvent(
                    $row['id'],
                    $row['user_id'],
                    $row['event_id'],
                    $row['role'],
                    $row['present']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?UsersInEvent {
        $result = DatabaseProvider::query("SELECT * FROM users_in_events WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new UsersInEvent(
                $row['id'],
                $row['user_id'],
                $row['event_id'],
                $row['role'],
                $row['present']
            );
        }
        return null;
    }

    public static function insert(UsersInEvent $uie): bool {
        return DatabaseProvider::query(
            "INSERT INTO users_in_events (`id`, `user_id`, `event_id`, `role`, `present`)
                    VALUES ($uie->id, $uie->user_id, $uie->event_id, '$uie->role', '$uie->present');"
        );
    }

    public static function update(UsersInEvent $uie): bool {
        return DatabaseProvider::query(
            "UPDATE users_in_events SET `user_id` = $uie->user_id, `event_id` = $uie->event_id, `role` = '$uie->role',
                        `present` = '$uie->present' WHERE `id` = $uie->id;"
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
    public function getPresent(): string {
        return $this->present;
    }

    /**
     * @return string
     */
    public function getRole(): string {
        return $this->role;
    }

    /**
     * @return int
     */
    public function getUserId(): int {
        return $this->user_id;
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
     * @param string $present
     * @throws Exception
     */
    public function setPresent(string $present): void {
        switch ($present) {
            case 'yes':
            case 'no':
            case 'maybe':
                $this->present = $present;
                break;
            default:
                throw new Exception('Unhandled content of string.');
        }
    }

    /**
     * @param string $role
     * @throws Exception
     */
    public function setRole(string $role): void {
        switch ($role) {
            case 'organizer':
            case 'participant':
                $this->role = $role;
                break;
            default:
                throw new Exception('Unhandled content of string.');
        }
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }
}
