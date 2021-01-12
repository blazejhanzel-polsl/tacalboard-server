<?php

class DatabaseProvider {
    private static self $instance;
    private object $connection;

    private string $db_server = "localhost:3306";
    private string $db_username = "root";
    private string $db_password = "";
    private string $db_name = "tacalboard";

    private static function checkInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabaseProvider();
            self::$instance->connect();
        }
        if (self::$instance->connection->connect_errno) {
            self::$instance->connect();
        }
    }

    private function connect() {
        $this->connection = new mysqli($this->db_server, $this->db_username, $this->db_password, $this->db_name);
        if ($this->connection->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->connection->connect_error;
            exit();
        }
    }

    public static function query($sql) {
        self::checkInstance();
        return self::$instance->connection->query($sql);
    }
}