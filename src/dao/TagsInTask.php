<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class TagsInTask {
    private int $id;
    private int $tag_id;
    private int $task_id;

    public function __construct(int $id, int $tag_id, int $task_id) {
        $this->setId($id);
        $this->setTagId($tag_id);
        $this->setTaskId($task_id);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM tags_in_tasks WHERE `id` = $id;");
    }

    public static function getAllByTaskId(int $id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM tags_in_tasks WHERE `task_id` = $id;");
        if ($result->num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new TagsInTask(
                    $row['id'],
                    $row['tag_id'],
                    $row['task_id']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?TagsInTask {
        $result = DatabaseProvider::query("SELECT * FROM tags_in_tasks WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new TagsInTask(
                $row['id'],
                $row['tag_id'],
                $row['task_id']
            );
        }
        return null;
    }

    public static function insert(TagsInTask $tit): bool {
        return DatabaseProvider::query(
            "INSERT INTO tags_in_tasks (`id`, `tag_id`, `task_id`) VALUES ($tit->id, $tit->tag_id, $tit->task_id);"
        );
    }

    public static function update(TagsInTask $tit): bool {
        return DatabaseProvider::query(
            "UPDATE tags_in_tasks SET `tag_id` = $tit->tag_id, `task_id` = $tit->task_id WHERE `id` = $tit->id;"
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
     * @return int
     */
    public function getTagId(): int {
        return $this->tag_id;
    }

    /**
     * @return int
     */
    public function getTaskId(): int {
        return $this->task_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param int $tag_id
     */
    public function setTagId(int $tag_id): void {
        $this->tag_id = $tag_id;
    }

    /**
     * @param int $task_id
     */
    public function setTaskId(int $task_id): void {
        $this->task_id = $task_id;
    }
}
