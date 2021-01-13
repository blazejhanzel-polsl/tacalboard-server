<?php


class UsersInEvent {
    private int $id;
    private int $user_id;
    private int $event_id;
    private string $role;
    private string $present;

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
