<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class User {
    private int $id;
    private string $email;
    private string $password;

    public function __construct(int $id, string $email, string $password) {
        $this->setId($id);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM users WHERE `id` = $id;");
    }

    public static function getById(int $id): ?User {
        $result = DatabaseProvider::query("SELECT * FROM users WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new User(
                $row['id'],
                $row['email'],
                $row['password']
            );
        }
        return null;
    }

    public static function insert(User $u): bool {
        return DatabaseProvider::query(
            "INSERT INTO users (`id`, `email`, `password`) VALUES ($u->id, '$u->email', '$u->password');"
        );
    }

    public static function update(User $u): bool {
        return DatabaseProvider::query(
            "UPDATE users SET `email` = '$u->email', `password` = '$u->password' WHERE `id` = $u->id;"
        );
    }

    // Getters and setters

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
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
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }
}