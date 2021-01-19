<?php
require_once __DIR__ . '/../DatabaseProvider.php';
require_once __DIR__ . '/../datatypes/ReturnCodes.php';
require_once __DIR__ . '/../datatypes/Service.php';


class Authorize extends Service {

    protected function doDelete(): void {
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
            session_destroy();
        }
    }

    protected function doGet(): void {
        if (isset($_SESSION['user_id'])) {
            echo json_encode(array(
                'email' => $_SESSION['user_id']
            ));
        } else {
            echo new ReturnCode\AuthorizationNotLogged();
        }
    }

    protected function doPost(): void {
        $json = json_decode(file_get_contents('php://input'));
        $email = $json->email;
        $password = $json->password;

        $result = DatabaseProvider::query("SELECT `id`, `password` FROM `users` WHERE email = '$email';");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (strcmp($row['password'], $password) === 0) {
                // successful login
                $_SESSION['user_id'] = $row['id'];
            }
            else {
                echo new ReturnCode\DataNotEqual();
            }
        }
        else {
            echo new ReturnCode\NotFound();
        }
    }
}
