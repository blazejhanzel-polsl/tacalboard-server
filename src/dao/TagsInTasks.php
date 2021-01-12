<?php


class TagsInTasks {
    private int $id;
    private int $tag_id;
    private int $task_id;

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
