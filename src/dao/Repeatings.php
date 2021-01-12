<?php


class Repeatings {
    private int $id;
    private bool $monday;
    private bool $tuesday;
    private bool $wednesday;
    private bool $thursday;
    private bool $friday;
    private bool $saturday;
    private bool $sunday;
    private int $step;
    private string $end_date;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEndDate(): string {
        return $this->end_date;
    }

    /**
     * @return int
     */
    public function getStep(): int {
        return $this->step;
    }

    /**
     * @return bool
     */
    public function isFriday(): bool {
        return $this->friday;
    }

    /**
     * @return bool
     */
    public function isMonday(): bool {
        return $this->monday;
    }

    /**
     * @return bool
     */
    public function isSaturday(): bool {
        return $this->saturday;
    }

    /**
     * @return bool
     */
    public function isSunday(): bool {
        return $this->sunday;
    }

    /**
     * @return bool
     */
    public function isThursday(): bool {
        return $this->thursday;
    }

    /**
     * @return bool
     */
    public function isTuesday(): bool {
        return $this->tuesday;
    }

    /**
     * @return bool
     */
    public function isWednesday(): bool {
        return $this->wednesday;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param string $end_date
     * @throws Exception
     */
    public function setEndDate(string $end_date): void {
        if (preg_match('/[0-9]{1,4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $end_date)) {
            $this->end_date = $end_date;
        }
    else {
            throw new Exception ("Unhandled date format.");
        }
    }

    /**
     * @param bool $friday
     */
    public function setFriday(bool $friday): void {
        $this->friday = $friday;
    }

    /**
     * @param bool $monday
     */
    public function setMonday(bool $monday): void {
        $this->monday = $monday;
    }

    /**
     * @param bool $saturday
     */
    public function setSaturday(bool $saturday): void {
        $this->saturday = $saturday;
    }

    /**
     * @param int $step
     */
    public function setStep(int $step): void {
        $this->step = $step;
    }

    /**
     * @param bool $sunday
     */
    public function setSunday(bool $sunday): void {
        $this->sunday = $sunday;
    }

    /**
     * @param bool $thursday
     */
    public function setThursday(bool $thursday): void {
        $this->thursday = $thursday;
    }

    /**
     * @param bool $tuesday
     */
    public function setTuesday(bool $tuesday): void {
        $this->tuesday = $tuesday;
    }

    /**
     * @param bool $wednesday
     */
    public function setWednesday(bool $wednesday): void {
        $this->wednesday = $wednesday;
    }
}