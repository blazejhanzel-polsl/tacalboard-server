<?php
require_once __DIR__ . '/../DatabaseProvider.php';
require_once __DIR__ . '/ReturnCode.php';
require_once __DIR__ . '/ReturnCodes.php';


abstract class Service {
    protected array $args;

    final protected function isArg(string $argString): bool {
        $args = array_filter(explode('/', $argString));

        if (count($this->args) == count($args)) {
            $i = 0;
            foreach ($args as $arg) {
                if (strcmp("*", $arg) === 0) {
                    $i++;
                    continue;
                } else {
                    if (strcmp($arg, $this->args[$i]) !== 0) {
                        return false;
                    }
                }
                $i++;
            }
            return true;
        }
        return false;
    }

    protected function doDelete(): ?ReturnCode {
        return null;
    }
    protected function doPut(): ?ReturnCode {
        return null;
    }
    protected function doPatch(): ?ReturnCode {
        return null;
    }

    abstract protected function doGet(): ?ReturnCode;
    abstract protected function doPost(): ?ReturnCode;

    final public function proceed(array $args): void {
        $this->args = $args;
        $return = null;

        DatabaseProvider::transactionBegin();
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'DELETE':
                $return = $this->doDelete();
                break;
            case 'GET':
            default:
                $return = $this->doGet();
                break;
            case 'PATCH':
                $return = $this->doPatch();
                break;
            case 'POST':
                $return = $this->doPost();
                break;
            case 'PUT':
                $return = $this->doPut();
                break;
        }
        DatabaseProvider::transactionEnd();

        if (!is_null($return)) {
            switch ($return->getStatus()) {
                default:
                    echo $return;
                    break;
                case 200:
                case 204:
                    break;
            }
        } else {
            echo new ReturnCode\MethodNotAllowed();
        }
    }
}
