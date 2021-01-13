<?php


abstract class Service {
    protected function doDelete(): void {}

    abstract protected function doGet(): void;
    abstract protected function doPost(): void;

    final public function proceed(): void {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'DELETE':
                $this->doDelete();
                break;
            case 'GET':
            default:
                $this->doGet();
                break;
            case 'POST':
                $this->doPost();
                break;
        }
    }
}