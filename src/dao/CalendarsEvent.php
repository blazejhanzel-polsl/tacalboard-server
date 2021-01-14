<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class CalendarsEvent {
    private int $id;
    private int $calendar_id;
    private string $title;
    private bool $all_day;
    private string $start_date;
    private string $end_date;
    private int $repeating_id;
    private string $location;
    private string $color;
    private string $description;
    private string $visibility;
    private string $accessibility;

    public function __construct(int $id, int $calendar_id, string $title, bool $all_day, string $start_date, string $end_date,
      ?int $repeating_id, ?string $location, ?string $color, ?string $description, string $visibility, string $accessibility) {
        $this->setId($id);
        $this->setCalendarId($calendar_id);
        $this->setTitle($title);
        $this->setAllDay($all_day);
        $this->setStartDate($start_date);
        $this->setEndDate($end_date);
        $this->setRepeatingId($repeating_id);
        $this->setLocation($location);
        $this->setColor($color);
        $this->setDescription($description);
        $this->setVisibility($visibility);
        $this->setAccessibility($accessibility);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM calendars_events WHERE `id` = $id;");
    }

    public static function getAllByCalendarId(int $calendar_id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM calendars_events WHERE `calendar_id` = $calendar_id ORDER BY `start_date`;");
        if ($result->num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new CalendarsEvent(
                    $row['id'],
                    $row['calendar_id'],
                    $row['title'],
                    $row['all_day'],
                    $row['start_date'],
                    $row['end_date'],
                    $row['repeating_id'],
                    $row['location'],
                    $row['color'],
                    $row['description'],
                    $row['visibility'],
                    $row['accessibility']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?CalendarsEvent {
        $result = DatabaseProvider::query("SELECT * FROM calendars_events WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new CalendarsEvent(
                $row['id'],
                $row['calendar_id'],
                $row['title'],
                $row['all_day'],
                $row['start_date'],
                $row['end_date'],
                $row['repeating_id'],
                $row['location'],
                $row['color'],
                $row['description'],
                $row['visibility'],
                $row['accessibility']
            );
        }
        return null;
    }

    public static function insert(CalendarsEvent $cal): bool {
        return DatabaseProvider::query(
            "INSERT INTO calendars_events (`id`, `calendar_id`, `title`, `all_day`, `start_date`, `end_date`, `repeating_id`,
                              `location`, `color`, `description`, `visibility`, `accessibility`)
                              VALUES ($cal->id, $cal->calendar_id, '$cal->title', $cal->all_day, '$cal->start_date', '$cal->end_date',
                                      $cal->repeating_id, '$cal->location', '$cal->color', '$cal->description', '$cal->visibility', '$cal->accessibility');"
        );
    }

    public static function update(CalendarsEvent $cal): bool {
        return DatabaseProvider::query(
            "UPDATE calendars_events SET `calendar_id` = $cal->calendar_id, `title` = '$cal->title', `all_day` = $cal->all_day,
                            `start_date` = '$cal->start_date', `end_date` = '$cal->end_date', `repeating_id` = $cal->repeating_id,
                            `location` = '$cal->location', `color` = '$cal->color', `description` = '$cal->description',
                            `visibility` = '$cal->visibility', `accessibility` = '$cal->accessibility' WHERE `id` = $cal->id;"
        );
    }

    // Getters and setters

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
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getVisibility(): string {
        return $this->visibility;
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
     * @param string $title
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * @param string $visibility
     * @throws Exception
     */
    public function setVisibility(string $visibility): void {
        switch ($visibility) {
            case 'private':
            case 'public':
                $this->visibility = $visibility;
                break;
            default:
                throw new Exception('Unhandled content of string.');
        }
    }
}
