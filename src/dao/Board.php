<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class Board {
    private int $id;
    private int $project_id;
    private string $name;
    private string $icon;
    private int $position;

    public function __construct(int $id, int $project_id, string $name, string $icon, int $position) {
        $this->setId($id);
        $this->setProjectId($project_id);
        $this->setName($name);
        $this->setIcon($icon);
        $this->setPosition($position);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM boards WHERE `id` = $id;");
    }

    public static function getAllByProjectId(int $project_id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM boards WHERE `project_id` = $project_id ORDER BY `position`;");
        if ($result->num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Board(
                    $row['id'],
                    $row['project_id'],
                    $row['name'],
                    $row['icon'],
                    $row['position']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?Board {
        $result = DatabaseProvider::query("SELECT * FROM boards WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Board(
                $row['id'],
                $row['project_id'],
                $row['name'],
                $row['icon'],
                $row['position']
            );
        } else {
            return null;
        }
    }

    public static function insert(Board $board): bool {
        return DatabaseProvider::query(
            "INSERT INTO boards (`id`, `project_id`, `name`, `icon`, `position`)
                    VALUES ($board->id, $board->project_id, '$board->name', '$board->icon', $board->position);"
        );
    }

    public static function update(Board $board): bool {
        return DatabaseProvider::query(
            "UPDATE boards SET `project_id` = $board->project_id, `name` = '$board->name', `icon` = '$board->icon',
                  `position` = $board->position WHERE `id` = $board->id;"
        );
    }

    // Getters and setters

    /**
     * @return string
     */
    public function getIcon(): string {
        return $this->icon;
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
    public function getProjectId(): int {
        return $this->project_id;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon): void {
        $this->icon = $icon;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void {
        $this->position = $position;
    }

    /**
     * @param int $project_id
     */
    public function setProjectId(int $project_id): void {
        $this->project_id = $project_id;
    }
}