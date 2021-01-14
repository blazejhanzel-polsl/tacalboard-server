<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class Team {
    private int $id;
    private string $name;

    public function __construct(int $id, int $name) {
        $this->setId($id);
        $this->setName($name);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM teams WHERE `id` = $id;");
    }

    public static function getById(int $id): ?Team {
        $result = DatabaseProvider::query("SELECT * FROM teams WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Team(
                $row['id'],
                $row['name']
            );
        }
        return null;
    }

    public static function insert(Team $t): bool {
        return DatabaseProvider::query(
            "INSERT INTO teams (`id`, `name`) VALUES ($t->id, '$t->name');"
        );
    }

    public static function update(Team $t): bool {
        return DatabaseProvider::query(
            "UPDATE teams SET `name` = '$t->name' WHERE `id` = $t->id;"
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
}
