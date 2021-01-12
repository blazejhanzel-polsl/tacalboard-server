<?php


class CalendarsEvents {
    private int $id;
    private int $calendar_id;
    private string $tilte;
    private bool $all_day;
    private string $start_date;
    private string $end_date;
    private int $repeating_id;
    private string $location;
    private string $color;
    private string $description;
    private string $visability;
    private string $accessibility;

    /**
     * @return string
     */
    public function getAccessibility(): string {
        return $this->accessibility;
    }

    /**
     * @return int
     */
    public function getCalendarId(): int {
        return $this->calendar_id;
    }

    /**
     * @return string
     */
    public function getColor(): string {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
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
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLocation(): string {
        return $this->location;
    }

    /**
     * @return int
     */
    public function getRepeatingId(): int {
        return $this->repeating_id;
    }

    /**
     * @return string
     */
    public function getStartDate(): string {
        return $this->start_date;
    }

    /**
     * @return string
     */
    public function getTilte(): string {
        return $this->tilte;
    }

    /**
     * @return string
     */
    public function getVisability(): string {
        return $this->visability;
    }

    /**
     * @return bool
     */
    public function isAllDay(): bool {
        return $this->all_day;
    }

    /**
     * @param string $accessibility
     * @throws Exception
     */
    public function setAccessibility(string $accessibility): void {
        switch ($accessibility) {
            case 'free':
            case 'busy':
            case 'pre-approval':
            case 'unavailable':
                $this->accessibility = $accessibility;
                break;
            default:
                throw new Exception('Unhandled content of string.');
        }
    }

    /**
     * @param bool $all_day
     */
    public function setAllDay(bool $all_day): void {
        $this->all_day = $all_day;
    }

    /**
     * @param int $calendar_id
     */
    public function setCalendarId(int $calendar_id): void {
        $this->calendar_id = $calendar_id;
    }

    /**
     * @param string $color
     * @throws Exception
     */
    public function setColor(string $color): void {
        if (strlen($color) === 7) {
            $this->color = $color;
        }
        else {
            throw new Exception ("String containing color must be 7 characters long.");
        }
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void {
        $this->description = $description;
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
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void {
        $this->location = $location;
    }

    /**
     * @param int $repeating_id
     */
    public function setRepeatingId(int $repeating_id): void {
        $this->repeating_id = $repeating_id;
    }

    /**
     * @param string $start_date
     * @throws Exception
     */
    public function setStartDate(string $start_date): void {
        if (preg_match('/[0-9]{1,4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $start_date)) {
            $this->start_date = $start_date;
        }
    else {
            throw new Exception ("Unhandled date format.");
        }
    }

    /**
     * @param string $tilte
     */
    public function setTilte(string $tilte): void {
        $this->tilte = $tilte;
    }

    /**
     * @param string $visability
     * @throws Exception
     */
    public function setVisability(string $visability): void {
        switch ($visability) {
            case 'private':
            case 'public':
                $this->visability = $visability;
                break;
            default:
                throw new Exception('Unhandled content of string.');
        }
    }
}
