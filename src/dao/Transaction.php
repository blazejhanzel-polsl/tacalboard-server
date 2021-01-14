<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class Transaction {
    private int $id;
    private int $user_id;
    private string $transaction_date;
    private int $amount_paid;
    private string $transaction_currency;
    private string $transaction_status;

    public function __construct(int $id, int $user_id, string $transaction_date, int $amount_paid,
                                ?string $transaction_currency, string $transaction_status) {
        $this->setId($id);
        $this->setUserId($user_id);
        $this->setTransactionDate($transaction_date);
        $this->setAmountPaid($amount_paid);
        $this->setTransactionCurrency($transaction_currency);
        $this->setTransactionStatus($transaction_status);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM transactions WHERE `id` = $id;");
    }

    public static function getAllByUserId(int $id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM transactions WHERE `user_id` = $id ORDER BY `transaction_date`;");
        if ($result->num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Transaction(
                    $row['id'],
                    $row['user_id'],
                    $row['transaction_date'],
                    $row['amount_paid'] * 100,
                    $row['transaction_currency'],
                    $row['transaction_status']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?Transaction {
        $result = DatabaseProvider::query("SELECT * FROM transactions WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Transaction(
                $row['id'],
                $row['user_id'],
                $row['transaction_date'],
                $row['amount_paid'] * 100,
                $row['transaction_currency'],
                $row['transaction_status']
            );
        }
        return null;
    }

    public static function insert(Transaction $t): bool {
        return DatabaseProvider::query(
            "INSERT INTO transactions (`id`, `user_id`, `transaction_date`, `amount_paid`, `transaction_currency`, `transaction_status`)
                    VALUES ($t->id, $t->user_id, '$t->transaction_date', ".($t->amount_paid / 100).", $t->transaction_currency,
                    '$t->transaction_status');"
        );
    }

    public static function update(Transaction $t): bool {
        return DatabaseProvider::query(
            "UPDATE transactions SET `user_id` = $t->user_id, `transaction_date` = '$t->transaction_date', `amount_paid` = $t->amount_paid,
                        `transaction_currency` = $t->transaction_currency, `transaction_status` = '$t->transaction_status' WHERE `id` = $t->id;"
        );
    }

    // Getters and setters

    /**
     * @return int
     */
    public function getAmountPaid(): int {
        return $this->amount_paid;
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
    public function getTransactionCurrency(): string {
        return $this->transaction_currency;
    }

    /**
     * @return string
     */
    public function getTransactionDate(): string {
        return $this->transaction_date;
    }

    /**
     * @return string
     */
    public function getTransactionStatus(): string {
        return $this->transaction_status;
    }

    /**
     * @return int
     */
    public function getUserId(): int {
        return $this->user_id;
    }

    /**
     * @param int $amount_paid
     */
    public function setAmountPaid(int $amount_paid): void {
        $this->amount_paid = $amount_paid;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param string $transaction_currency
     * @throws Exception
     */
    public function setTransactionCurrency(string $transaction_currency): void {
        if (strlen($transaction_currency) === 3) {
            $this->transaction_currency = $transaction_currency;
        }
        else {
            throw new Exception("Currency code must be 3 characters long.");
        }
    }

    /**
     * @param string $transaction_date
     * @throws Exception
     */
    public function setTransactionDate(string $transaction_date): void {
        if (preg_match('/[0-9]{1,4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $transaction_date)) {
            $this->transaction_date = $transaction_date;
        }
        else {
            throw new Exception ("Unhandled date format.");
        }
    }

    /**
     * @param string $transaction_status
     * @throws Exception
     */
    public function setTransactionStatus(string $transaction_status): void {
        switch ($transaction_status) {
            case 'correct':
            case 'cancelled':
            case 'in progress':
                $this->transaction_status = $transaction_status;
                break;
            default:
                throw new Exception('Unhandled content of string.');
        }
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }
}
