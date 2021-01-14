<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class TasksList {
    private int $id;
    private int $project_id;
    private string $name;
    private string $icon;
    private int $position;
    private bool $predefined;

    public function __construct(int $id, int $project_id, string $name, string $icon, int $position, bool $predefined) {
        $this->setId($id);
        $this->setProjectId($project_id);
        $this->setName($name);
        $this->setIcon($icon);
        $this->setPosition($position);
        $this->setPredefined($predefined);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM tasks_lists WHERE `id` = $id;");
    }

    public static function getAllByProjectId(int $id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM tasks_lists WHERE `project_id` = $id;");
        if ($result->num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new TasksList(
                    $row['id'],
                    $row['project_id'],
                    $row['name'],
                    $row['icon'],
                    $row['position'],
                    $row['predefined']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?TasksList {
        $result = DatabaseProvider::query("SELECT * FROM tasks_lists WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new TasksList(
                $row['id'],
                $row['project_id'],
                $row['name'],
                $row['icon'],
                $row['position'],
                $row['predefined']
            );
        }
        return null;
    }

    public static function insert(TasksList $tl): bool {
        return DatabaseProvider::query(
            "INSERT INTO tasks_lists (`id`, `project_id`, `name`, `icon`, `position`, `predefined`)
                    VALUES ($tl->id, $tl->project_id, '$tl->name', '$tl->icon', $tl->position, $tl->predefined);"
        );
    }

    public static function update(TasksList $tl): bool {
        return DatabaseProvider::query(
            "UPDATE tasks_lists SET `project_id` = $tl->project_id, `name` = '$tl->name', `icon` = '$tl->icon',
                       `position` = $tl->position, `predefined` = $tl->predefined WHERE `id` = $tl->id;"
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
     * @return bool
     */
    public function isPredefined(): bool {
        return $this->predefined;
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
     * @param bool $predefined
     */
    public function setPredefined(bool $predefined): void {
        $this->predefined = $predefined;
    }

    /**
     * @param int $project_id
     */
    public function setProjectId(int $project_id): void {
        $this->project_id = $project_id;
    }
}