<?php
require_once __DIR__ . '/../datatypes/ReturnCodes.php';
require_once __DIR__ . '/../datatypes/Service.php';


class Tasks extends Service {

    protected function doDelete(): void {
    }

    protected function doGet(): void {
        switch (count($this->args)) {
            default:
            case 0: {
                break;
            }
        }
    }

    protected function doPost(): void {
    }
}
