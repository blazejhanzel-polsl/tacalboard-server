<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class Calendar {
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
        return DatabaseProvider::query("DELETE FROM calendars WHERE `id` = $id;");
    }

    public static function getAllByProjectId(int $project_id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM calendars WHERE `project_id` = $project_id ORDER BY `position`;");
        if ($result->num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Calendar(
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

    public static function getById(int $id): ?Calendar {
        $result = DatabaseProvider::query("SELECT * FROM calendars WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Calendar(
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

    public static function insert(Calendar $cal): bool {
        return DatabaseProvider::query(
            "INSERT INTO calendars (`id`, `project_id`, `name`, `icon`, `position`) 
                    VALUES ($cal->id, $cal->project_id, '$cal->name', '$cal->icon', $cal->position);"
        );
    }

    public static function update(Calendar $cal): bool {
        return DatabaseProvider::query(
            "UPDATE calendars SET `project_id` = $cal->project_id, `name` = '$cal->name', `icon` = '$cal->icon',
                     `position` = $cal->position WHERE `id` = $cal->id;"
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
