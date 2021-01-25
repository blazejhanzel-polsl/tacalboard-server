<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class UsersInTeam {
    private int $id;
    private int $user_id;
    private int $team_id;
    private string $role;

    public function __construct(int $id, int $user_id, int $team_id, string $role) {
        $this->setId($id);
        $this->setUserId($user_id);
        $this->setTeamId($team_id);
        $this->setRole($role);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM users_in_teams WHERE `id` = $id;");
    }

    public static function getAllByTeamId(int $id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM users_in_teams WHERE `team_id` = $id;");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new UsersInTeam(
                    $row['id'],
                    $row['user_id'],
                    $row['team_id'],
                    $row['role']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?UsersInTeam {
        $result = DatabaseProvider::query("SELECT * FROM users_in_teams WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new UsersInTeam(
                $row['id'],
                $row['user_id'],
                $row['team_id'],
                $row['role']
            );
        }
        return null;
    }

    public static function getUserRoleByProjectId(int $user_id, int $project_id): string {
        $result = DatabaseProvider::query("SELECT role FROM users_in_teams uit JOIN projects p ON uit.team_id = p.team_id WHERE uit.user_id = $user_id AND p.id = $project_id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['role'];
        } else {
            return "none";
        }
    }

    public static function getUserRoleByTeamId(int $user_id, int $team_id): string {
        $result = DatabaseProvider::query("SELECT role FROM users_in_teams WHERE user_id = $user_id AND team_id = $team_id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['role'];
        } else {
            return "none";
        }
    }

    public static function insert(UsersInTeam $uit): bool {
        return DatabaseProvider::query(
            "INSERT INTO users_in_teams (`id`, `user_id`, `team_id`, `role`)
                    VALUES ($uit->id, $uit->user_id, $uit->team_id, '$uit->role');"
        );
    }

    public static function update(UsersInTeam $uit): bool {
        return DatabaseProvider::query(
            "UPDATE users_in_teams SET `user_id` = $uit->user_id, `team_id` = $uit->team_id, `role` = '$uit->role' WHERE `id` = $uit->id;"
        );
    }

    // Getters and setters

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
