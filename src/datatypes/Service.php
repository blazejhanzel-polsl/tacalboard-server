<?php


abstract class Service {
    protected array $args;

    protected function doDelete(): void {
        echo new ReturnCode\MethodNotAllowed();
    }
    protected function doPut(): void {
        echo new ReturnCode\MethodNotAllowed();
    }
    protected function doPatch(): void {
        echo new ReturnCode\MethodNotAllowed();
    }

    abstract protected function doGet(): void;
    abstract protected function doPost(): void;

    final public function proceed(array $args): void {
        $this->args = $args;

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
            case 'PUT':
                $this->doPut();
                break;
            case 'PATCH':
                $this->doPatch();
                break;
        }
    }
}
