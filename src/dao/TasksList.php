<?php
require_once __DIR__ . '/../DatabaseProvider.php';
require_once __DIR__ . '/TasksList/Predefinition.php';

use TasksList\Predefinition;

class TasksList {
    private ?int $id = null;
    private int $project_id;
    private string $name;
    private string $icon;
    private int $position;
    private bool $predefined;

    private function __construct(int $id, int $project_id, string $name, string $icon, int $position, bool $predefined) {
        $this->setId($id);
        $this->setProjectId($project_id);
        $this->setName($name);
        $this->setIcon($icon);
        $this->setPosition($position);
        $this->setPredefined($predefined);
    }

    public static function create(int $project_id, string $name, string $icon, int $position, bool $predefined) {
        return new TasksList(null, $project_id, $name, $icon, $position, $predefined);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM tasks_lists WHERE `id` = $id;");
    }

    public static function getAllByProjectId(int $id, Predefinition $p): array {
        $ret = array();
        $sql = "SELECT * FROM tasks_lists WHERE `project_id` = $id";
        if ($p->equals(Predefinition::ONLY_PREDEFINED())) {
            $sql .= ", `predefined` = true;";
        } else if ($p->equals(Predefinition::ONLY_USER_DEFINED())) {
            $sql .= ", `predefined` = false;";
        } else if ($p->equals(Predefinition::ALL())) {
            $sql .= ";";
        }

        $result = DatabaseProvider::query($sql);
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

    public static function movePosition(TasksList $tl, int $direction): bool {
        if ($direction != 0) {
            $objs = TasksList::getAllByProjectId($tl->project_id, Predefinition::ONLY_USER_DEFINED());

            foreach ($objs as $obj) {
                if ($obj->position = ($tl->position + $direction)) {
                    $obj->position = $tl->position;
                    $tl->position = $tl->position + $direction;
                    try {
                        DatabaseProvider::transactionBegin();
                        TasksList::update($obj);
                        TasksList::update($tl);
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
