<?php
namespace ReturnCode;

use ReturnCode;

require_once __DIR__ . '/ReturnCode.php';


class AuthorizationNotLogged extends ReturnCode {
    public function __construct() {
        parent::__construct(
            401,
            "authorization-not-logged",
            "Unauthorized",
            "None user is currently logged in. Log in first, using suitable API request."
        );
    }
}

class AuthorizationRejected extends ReturnCode {
    public function __construct() {
        parent::__construct(
            401,
            "authorization-rejected",
            "Unauthorized",
            "Authorization expired or cannot be completed properly."
        );
    }
}

class Created extends ReturnCode {
    public function __construct() {
        parent::__construct(
            201,
            "created",
            "Created",
            "Resource created successfully."
        );
    }
}

class DatabaseQueryError extends ReturnCode {
    public function __construct() {
        parent::__construct(
            500,
            "database-query-error",
            "Internal Server Error",
            "Server encountered a problem in communication with database."
        );
    }
}

class DataNotEqual extends ReturnCode {
    public function __construct() {
        parent::__construct(
            409,
            "data-not-equal",
            "Conflict",
            "The request could not be completed due to a conflict with the current state of the resource."
        );
    }
}

class InsufficientContent extends ReturnCode {
    public function __construct() {
        parent::__construct(
            400,
            "insufficient-content",
            "Bad Request",
            "The request could not be proceed because not all needed data were provided."
        );
    }
}

class InsufficientPrivileges extends ReturnCode {
    public function __construct() {
        parent::__construct(
            403,
            "insufficient-privileges",
            "Forbidden",
            "Insufficient privileges to proceed the request."
        );
    }
}

class MethodNotAllowed extends ReturnCode {
    public function __construct() {
        parent::__construct(
            405,
            "method-not-allowed",
            "Method Not Allowed",
            "This endpoint doesn't provide functionality."
        );
    }
}

class NoContent extends ReturnCode {
    public function __construct() {
        parent::__construct(
            204,
            "no-content",
            "No Content",
            "Request proceed with success. No content provided."
        );
    }
}

class NotFound extends ReturnCode {
    public function __construct() {
        parent::__construct(
            404,
            "not-found",
            "Not Found",
            "The server has not found anything matching the Request-URI."
        );
    }
}

class UniqueAlreadyUsed extends ReturnCode {
    public function __construct() {
        parent::__construct(
            409,
            "unique-already-used",
            "Conflict",
            "User tries to duplicate unique value."
        );
    }
}
