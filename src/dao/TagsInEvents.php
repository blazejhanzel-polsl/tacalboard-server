<?php


class TagsInEvents {
    private int $id;
    private int $tag_id;
    private int $event_id;

    /**
     * @return int
     */
    public function getEventId(): int {
        return $this->event_id;
    }

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
     * @param int $event_id
     */
    public function setEventId(int $event_id): void {
        $this->event_id = $event_id;
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
}
