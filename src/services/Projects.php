<?php
require_once __DIR__ . '/../datatypes/ReturnCodes.php';
require_once __DIR__ . '/../datatypes/Service.php';
require_once __DIR__ . '/../dao/Project.php';
require_once __DIR__ . '/../dao/UsersInTeam.php';


class Projects extends Service {

    protected function doGet(): void {
        if (isset($this->args[0])) {
            if (isset($_SESSION['user_id'])) {
                $role = UsersInTeam::getUserRoleByProjectId($_SESSION['user_id'], $this->args[0]);
                if ($role == "owner" || $role == "member") {
                    $project = Project::getById($this->args[0]);
                    echo json_encode(
                        array(
                            "id" => $project->getId(),
                            "team_id" => $project->getTeamId(),
                            "name" => $project->getName(),
                            "position" => $project->getPosition()
                        )
                    );
                } else {
                    echo new ReturnCode\NotFound();
                }
            } else {
                echo new ReturnCode\AuthorizationNotLogged();
            }
        } else {
            if (isset($_SESSION['user_id'])) {
                $projects = Project::getAllByUserId($_SESSION['user_id']);
                $json = array();
                /* @var $p Project */
                foreach ($projects as $p) {
                    $json[] = array(
                        "id" => $p->getId(),
                        "team_id" => $p->getTeamId(),
                        "name" => $p->getName(),
                        "position" => $p->getPosition()
                    );
                }
                echo json_encode($json);
            } else {
                echo new ReturnCode\AuthorizationNotLogged();
            }
        }
    }

    protected function doPost(): void {
        if (isset($_SESSION['user_id'])) {
            $json = json_decode(file_get_contents('php://input'));

            if (isset($json->team_id, $json->name)) {
                $role = UsersInTeam::getUserRoleByTeamId($_SESSION['user_id'], $json->team_id);
                if ($role == "owner" || $role == "member") {
                    $project = Project::create($json->team_id, $json->name);
                    if (Project::insert($project)) {
                        echo new ReturnCode\Created();
                    } else {
                        echo new ReturnCode\DatabaseQueryError();
                    }
                } else {
                    echo new ReturnCode\InsufficientPrivileges();
                }
            } else {
                echo new ReturnCode\InsufficientContent();
            }
        } else {
            echo new ReturnCode\AuthorizationNotLogged();
        }
    }

    protected function doPut(): void {
        if (isset($_SESSION['user_id'])) {
            $json = json_decode(file_get_contents('php://input'));

            if (isset($json->id, $json->team_id, $json->name, $json->position)) {
                $role = UsersInTeam::getUserRoleByTeamId($_SESSION['user_id'], $json->team_id);
                if ($role == "owner" || $role == "member") {
                    if (!is_null(Project::getById($json->id))) {
                        $project = Project::create($json->team_id, $json->name, $json->position);
                        $project->setId($json->id);

                        if (Project::update($project)) {
                            echo new ReturnCode\NoContent();
                        } else {
                            echo new ReturnCode\DatabaseQueryError();
                        }
                    } else {
                        echo new ReturnCode\NotFound();
                    }
                } else {
                    echo new ReturnCode\InsufficientPrivileges();
                }
            } else {
                echo new ReturnCode\InsufficientContent();
            }
        } else {
            echo new ReturnCode\AuthorizationNotLogged();
        }
    }

    protected function doDelete(): void {
        if (isset($this->args[0])) {
            if (isset($_SESSION['user_id'])) {
                $role = UsersInTeam::getUserRoleByProjectId($_SESSION['user_id'], $this->args[0]);
                if ($role == "owner") {
                    if (!Project::deleteById($this->args[0])) {
                        echo new ReturnCode\DatabaseQueryError();
                    }
                } else {
                    if ($role != "member") {
                        echo new ReturnCode\NotFound();
                    } else {
                        echo new ReturnCode\InsufficientPrivileges();
                    }
                }
            } else {
                echo new ReturnCode\AuthorizationNotLogged();
            }
        } else {
            echo new ReturnCode\MethodNotAllowed();
        }
    }
}
