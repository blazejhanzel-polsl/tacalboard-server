<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class Workspace {
    private int $id;
    private int $user_id;
    private string $name;

    public function __construct(int $id, int $user_id, string $name) {
        $this->setId($id);
        $this->setUserId($user_id);
        $this->setName($name);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM workspaces WHERE `id` = $id;");
    }

    public static function getAllByUserId(int $id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM workspaces WHERE `user_id` = $id;");
        if ($result->num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Workspace(
                    $row['id'],
                    $row['user_id'],
                    $row['name']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?Workspace {
        $result = DatabaseProvider::query("SELECT * FROM workspaces WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Workspace(
                $row['id'],
                $row['user_id'],
                $row['name']
            );
        }
        return null;
    }

    public static function insert(Workspace $w): bool {
        return DatabaseProvider::query(
            "INSERT INTO workspaces (`id`, `user_id`, `name`) VALUES ($w->id, $w->user_id, '$w->name');"
        );
    }

    public static function update(Workspace $w): bool {
        return DatabaseProvider::query(
            "UPDATE workspaces SET `user_id` = $w->user_id, `name` = '$w->name'  WHERE `id` = $w->id;"
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
    public function getUserId(): int {
        return $this->user_id;
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
     * @param int $user_id
     */
    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }
}