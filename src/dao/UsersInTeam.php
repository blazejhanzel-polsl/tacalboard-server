<?php


class UsersInTeam {
    private int $id;
    private int $user_id;
    private int $team_id;
    private string $role;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
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
    public function getTeamId(): int {
        return $this->team_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int {
        return $this->user_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param string $role
     * @throws Exception
     */
    public function setRole(string $role): void {
        switch ($role) {
            case 'owner':
            case 'member':
                $this->role = $role;
                break;
            default:
                throw new Exception('Unhandled content of string.');
        }
    }

    /**
     * @param int $team_id
     */
    public function setTeamId(int $team_id): void {
        $this->team_id = $team_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }
}
