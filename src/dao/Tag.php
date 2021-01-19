<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class Tag {
    private ?int $id = null;
    private int $project_id;
    private string $icon;
    private string $name;
    private int $position;

    private function __construct(int $id, int $project_id, string $icon, string $name, int $position) {
        $this->setId($id);
        $this->setProjectId($project_id);
        $this->setIcon($icon);
        $this->setName($name);
        $this->setPosition($position);
    }

    public static function create(int $project_id, string $icon, string $name, int $position): Tag {
        return new Tag(null, $project_id, $icon, $name, $position);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM tags WHERE `id` = $id;");
    }

    public static function getAllByProjectId(int $project_id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM tags WHERE `project_id` = $project_id ORDER BY `position`;");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Tag(
                    $row['id'],
                    $row['project_id'],
                    $row['icon'],
                    $row['name'],
                    $row['position']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?Tag {
        $result = DatabaseProvider::query("SELECT * FROM tags WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Tag(
                $row['id'],
                $row['project_id'],
                $row['icon'],
                $row['name'],
                $row['position']
            );
        } else {
            return null;
        }
    }

    public static function insert(Tag $tag): bool {
        return DatabaseProvider::query(
            "INSERT INTO tags (`id`, `project_id`, `icon`, `name`, `position`)".
            "VALUES ($tag->id, $tag->project_id, '$tag->icon', '$tag->name', $tag->position);"
        );
    }

    public static function movePosition(Tag $tag, int $direction): bool {
        if ($direction != 0) {
            $objs = Tag::getAllByProjectId($tag->project_id);

            foreach ($objs as $obj) {
                if ($obj->position = ($tag->position + $direction)) {
                    $obj->position = $tag->position;
                    $tag->position = $tag->position + $direction;
                    try {
                        DatabaseProvider::transactionBegin();
                        Tag::update($obj);
                        Tag::update($tag);
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

    public static function update(Tag $tag): bool {
        return DatabaseProvider::query(
            "UPDATE tags SET `project_id` = $tag->project_id, ".
            "`icon` = '$tag->icon', `name` = '$tag->name', `position` = $tag->position WHERE `id` = $tag->id;"
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
