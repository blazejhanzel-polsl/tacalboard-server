<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class Project {
    private ?int $id;
    private int $team_id;
    private string $name;
    private ?int $position;

    private function __construct(?int $id, int $team_id, string $name, ?int $position) {
        $this->setId($id);
        $this->setTeamId($team_id);
        $this->setName($name);
        $this->setPosition($position);
    }

    public static function create(int $team_id, string $name, int $position = null): Project {
        return new Project(null, $team_id, $name, $position);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM projects WHERE `id` = $id;");
    }

    public static function getAllByTeamId(int $team_id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM projects WHERE `team_id` = $team_id ORDER BY `position`");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Project(
                    $row['id'],
                    $row['team_id'],
                    $row['name'],
                    $row['position']
                );
            }
        }
        return $ret;
    }

    public static function getAllByUserId(int $id): array {
        $ret = array();
        $result = DatabaseProvider::query(
            "SELECT p.* FROM projects p JOIN users_in_teams uit on p.team_id = uit.team_id
                    WHERE uit.user_id = $id ORDER BY p.position;"
        );
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Project(
                    $row['id'],
                    $row['team_id'],
                    $row['name'],
                    $row['position']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?Project {
        $result = DatabaseProvider::query("SELECT * FROM projects WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Project(
                $row['id'],
                $row['team_id'],
                $row['name'],
                $row['position']
            );
        }
        return null;
    }

    public static function insert(Project $proj): bool {
        DatabaseProvider::transactionBegin();
        $position = 1000 + DatabaseProvider::query("SELECT MAX(position) as max FROM projects WHERE team_id = $proj->team_id;")->fetch_assoc()['max'];
        $return = DatabaseProvider::query(
            "INSERT INTO projects (team_id, name, position) VALUES ($proj->team_id, '$proj->name', $position);"
        );
        DatabaseProvider::transactionEnd();
        return $return;
    }

    public static function update(Project $proj): bool {
        return DatabaseProvider::query(
            "UPDATE projects SET `team_id` = $proj->team_id, `name` = '$proj->name', `position` = $proj->position WHERE `id` = $proj->id;"
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
    public function getName(): string {
        return $this->name;
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
    public function getTeamId(): int {
        return $this->team_id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position): void {
        $this->position = $position;
    }

    /**
     * @param int $team_id
     */
    public function setTeamId(int $team_id): void {
        $this->team_id = $team_id;
    }
}
