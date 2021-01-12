<?php


class Subscriptions {
    private int $id;
    private int $user_id;
    private string $date_from;
    private string $date_to;
    private int $transaction_id;

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
