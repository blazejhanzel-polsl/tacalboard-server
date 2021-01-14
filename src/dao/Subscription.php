<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class Subscription {
    private int $id;
    private int $user_id;
    private string $date_from;
    private string $date_to;
    private int $transaction_id;

    public function __construct(int $id, int $user_id, string $date_from, string $date_to, int $transaction_id) {
        $this->setId($id);
        $this->setUserId($user_id);
        $this->setDateFrom($date_from);
        $this->setDateTo($date_to);
        $this->setTransactionId($transaction_id);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM subscriptions WHERE `id` = $id;");
    }

    public static function getAllByUserId(int $id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM subscriptions WHERE `user_id` = $id ORDER BY `date_from`;");
        if ($result->num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Subscription(
                    $row['id'],
                    $row['user_id'],
                    $row['date_from'],
                    $row['date_to'],
                    $row['transaction_id']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?Subscription {
        $result = DatabaseProvider::query("SELECT * FROM subscriptions WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Subscription(
                $row['id'],
                $row['user_id'],
                $row['date_from'],
                $row['date_to'],
                $row['transaction_id']
            );
        }
        return null;
    }

    public static function insert(Subscription $sub): bool {
        return DatabaseProvider::query(
            "INSERT INTO subscriptions (`id`, `user_id`, `date_from`, `date_to`, `transaction_id`)
                    VALUES ($sub->id, $sub->user_id, '$sub->date_from', '$sub->date_to', $sub->transaction_id);"
        );
    }

    public static function update(Subscription $sub): bool {
        return DatabaseProvider::query(
            "UPDATE subscriptions SET `user_id` = $sub->user_id, `date_from` = '$sub->date_from', `date_to` = '$sub->date_to',
                         `transaction_id` = $sub->transaction_id WHERE `id` = $sub->id;"
        );
    }

    // Getters and setters

    /**
     * @return string
     */
    public function getDateFrom(): string {
        return $this->date_from;
    }

    /**
     * @return string
     */
    public function getDateTo(): string {
        return $this->date_to;
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
    public function getTransactionId(): int {
        return $this->transaction_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int {
        return $this->user_id;
    }

    /**
     * @param string $date_from
     * @throws Exception
     */
    public function setDateFrom(string $date_from): void {
        if (preg_match('/[0-9]{1,4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $date_from)) {
            $this->date_from = $date_from;
        }
        else {
            throw new Exception ("Unhandled date format.");
        }
    }

    /**
     * @param string $date_to
     * @throws Exception
     */
    public function setDateTo(string $date_to): void {
        if (preg_match('/[0-9]{1,4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $date_to)) {
            $this->date_to = $date_to;
        }
        else {
            throw new Exception ("Unhandled date format.");
        }
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param int $transaction_id
     */
    public function setTransactionId(int $transaction_id): void {
        $this->transaction_id = $transaction_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }
}
