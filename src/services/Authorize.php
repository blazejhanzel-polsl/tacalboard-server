<?php
require_once __DIR__ . '/../DatabaseProvider.php';
require_once __DIR__ . '/../datatypes/ErrorReturn.php';
require_once __DIR__ . '/../datatypes/Service.php';


class Authorize extends Service {

    protected function doDelete(): void {
        if (isset($_SESSION['login'])) {
            unset($_SESSION['login']);
            session_destroy();
        }
    }

    protected function doGet(): void {
        if (isset($_SESSION['login'])) {
            echo json_encode(array(
                'email' => $_SESSION['login']
            ));
        } else {
            echo new ErrorReturn(
                'authorization-not-logged',
                'User not logged in',
                401,
                'None user is currently logged in. Log in using POST request.'
            );
        }
    }

    protected function doPost(): void {
        $json = json_decode(file_get_contents('php://input'));
        $email = $json->email;
        $password = $json->password;

        $result = DatabaseProvider::query('SELECT `password` FROM `users` WHERE email = "'. $email .'";');
        if ($result->num_rows > 0) {
            if (strcmp(($result->fetch_assoc())['password'], $password) === 0) {
                // successful login
                $_SESSION['login'] = $email;
            }
            else {
                echo (new ErrorReturn(
                    "authorization-wrong-password",
                    "Wrong password",
                    401,
                    "Authorization failed. Wrong password."
                ));
            }
        }
        else {
            echo (new ErrorReturn(
                "authorization-user-doesnt-exist",
                "User doesn't exist",
                401,
                "Authorization failed. User with specified e-mail doesn't exist."
            ));
        }
    }
}
