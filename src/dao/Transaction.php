<?php


class Transaction {
    private int $id;
    private int $user_id;
    private string $transaction_date;
    private int $amount_paid;
    private string $transaction_currency;
    private string $transaction_status;

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
