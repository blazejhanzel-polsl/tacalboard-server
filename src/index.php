<?php
session_start();

require_once __DIR__ . '/datatypes/ReturnCodes.php';
require_once __DIR__ . '/services/Authorize.php';
require_once __DIR__ . '/services/Projects.php';
require_once __DIR__ . '/services/Tasks.php';

class ServiceHandler {
    private static self $instance;

    private function __construct() {
        define('V_MAJOR', 1);
        define('V_MINOR', 0);
        define('V_RELEASE', 0);
    }

    public static function checkInstance() {
        if (!isset(self::$instance)) self::$instance = new ServiceHandler();
    }

    public static function main() {
        $request = array_filter(explode('/', $_SERVER['REQUEST_URI']));

        if (count($request) > 0) {
            switch ($request[1]) {
                default: {
                    echo new ReturnCode\MethodNotAllowed();
                    break;
                }

                // api path defining starts here

                case 'authorize': {
                    (new Authorize())->proceed(array_slice($request, 1));
                    break;
                }

                case 'projects': {
                    (new Projects())->proceed((array_slice($request, 1)));
                    break;
                }

                case 'tasks': {
                    (new Tasks())->proceed(array_slice($request, 1));
                    break;
                }
            }
        }
    }
}

// startup methods
header('Content-Type: application/json;charset=utf-8');
ServiceHandler::checkInstance();
ServiceHandler::main();
