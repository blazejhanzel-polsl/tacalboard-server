<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class User {
    private int $id;
    private string $email;
    private string $password;
    private ?string $confirmation_key;

    private function __construct(int $id, string $email, string $password, ?string $confirmation_key) {
        $this->setId($id);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setConfirmationKey($confirmation_key);
    }

    public static function create(string $email, string $password): User {
        return new User(null, $email, $password, md5($email . date("Y-m-d H:i:s") . $password));
    }

    public static function createFromJson(string $json): ?User {
        $obj = json_decode($json);
        if (isset($obj->id, $obj->email, $obj->password)) {
            return new User($obj->id, $obj->email, $obj->password, null);
        }
        return null;
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM users WHERE `id` = $id;");
    }

    public static function getByEmail(string $email): ?User {
        $result = DatabaseProvider::query("SELECT * FROM users WHERE `email` = $email;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['confirmation_key']
            );
        }
        return null;
    }

    public static function getById(int $id): ?User {
        $result = DatabaseProvider::query("SELECT * FROM users WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['confirmation_key']
            );
        }
        return null;
    }

    public static function insert(User $u): bool {
        return DatabaseProvider::query(
            "INSERT INTO users (`id`, `email`, `password`, `confirmation_key`) VALUES ($u->id, '$u->email', '$u->password', '$u->confirmation_key');"
        );
    }

    public static function update(User $u): bool {
        return DatabaseProvider::query(
            "UPDATE users SET `email` = '$u->email', `password` = '$u->password', `confirmation_key` = '$u->confirmation_key' WHERE `id` = $u->id;"
        );
    }

    // Getters and setters

    /**
     * @return string
     */
    public function getConfirmationKey(): string
    {
        return $this->confirmation_key;
    }

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
     * @param string $confirmation_key
     */
    public function setConfirmationKey(string $confirmation_key): void
    {
        $this->confirmation_key = $confirmation_key;
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
