<?php


class ReturnCode {
    protected string $type = "ok";
    protected string $title = "OK";
    protected int $status = 200;
    protected string $detail = "Request proceed with success.";
    protected string $instance = "unknown";

    /**
     * ReturnCode constructor.
     * @param string $type
     * @param string $title
     * @param int $status
     * @param string $detail
     */
    public function __construct(int $status, string $type, string $title, string $detail) {
        $this->setStatus($status);
        $this->setType($type);
        $this->setTitle($title);
        $this->setDetail($detail);
        $this->setInstance($_SERVER['REQUEST_URI']);
    }

    /**
     * @return string
     */
    final public function __toString(): string {
        $json = array(
            'type' => $this->type,
            'title' => $this->title,
            'status' => $this->status,
            'detail' => $this->detail,
            'instance' => $this->instance
        );

        http_response_code($this->status);

        if ($this->status == 204) return "";
        return json_encode($json);
    }

    /**
     * @param string $detail
     */
    final public function setDetail(string $detail): void {
        $this->detail = $detail;
    }

    /**
     * @param string $instance
     */
    final public function setInstance(string $instance): void {
        $this->instance = $instance;
    }

    /**
     * @param int $status
     */
    final public function setStatus(int $status): void {
        $this->status = $status;
    }

    /**
     * @param string $title
     */
    final public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * @param string $type
     */
    final public function setType(string $type): void {
        $this->type = $type;
    }
}
