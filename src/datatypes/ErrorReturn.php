<?php


class ErrorReturn {
    private string $type = "general-error";
    private string $title = "General error";
    private int $status = 400;
    private string $detail = "Unknown error has occurred. None details specified.";
    private string $instance = "unknown";

    /**
     * ErrorReturn constructor.
     * @param string $type
     * @param string $title
     * @param int $status
     * @param string $detail
     */
    public function __construct(string $type, string $title, int $status, string $detail) {
        $this->setType($type);
        $this->setTitle($title);
        $this->setStatus($status);
        $this->setDetail($detail);
        $this->setInstance($_SERVER['REQUEST_URI']);
    }

    /**
     * @return string
     */
    public function __toString(): string {
        $json = array(
            'type' => $this->type,
            'title' => $this->title,
            'status' => $this->status,
            'detail' => $this->detail,
            'instance' => $this->instance
        );

        http_response_code($this->status);

        return json_encode($json);
    }

    /**
     * @param string $detail
     */
    public function setDetail(string $detail): void {
        $this->detail = $detail;
    }

    /**
     * @param string $instance
     */
    public function setInstance(string $instance): void {
        $this->instance = $instance;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void {
        $this->status = $status;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void {
        $this->type = $type;
    }
}
