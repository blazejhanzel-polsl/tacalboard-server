<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class TagsInEvent {
    private int $id;
    private int $tag_id;
    private int $event_id;

    public function __construct(int $id, int $tag_id, int $event_id) {
        $this->setId($id);
        $this->setTagId($tag_id);
        $this->setEventId($event_id);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM tags_in_events WHERE `id` = $id;");
    }

    public static function getAllByEventId(int $id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM tags_in_events WHERE `event_id` = $id;");
        if ($result->num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new TagsInEvent(
                    $row['id'],
                    $row['tag_id'],
                    $row['event_id']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?TagsInEvent {
        $result = DatabaseProvider::query("SELECT * FROM tags_in_events WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new TagsInEvent(
                $row['id'],
                $row['tag_id'],
                $row['event_id']
            );
        }
        return null;
    }

    public static function insert(TagsInEvent $tie): bool {
        return DatabaseProvider::query(
            "INSERT INTO tags_in_events (`id`, `tag_id`, `event_id`) VALUES ($tie->id, $tie->tag_id, $tie->event_id);"
        );
    }

    public static function update(TagsInEvent $tie): bool {
        return DatabaseProvider::query(
            "UPDATE tags_in_events SET `tag_id` = $tie->tag_id, `event_id` = $tie->event_id WHERE `id` = $tie->id;"
        );
    }

    // Getters and setters

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
