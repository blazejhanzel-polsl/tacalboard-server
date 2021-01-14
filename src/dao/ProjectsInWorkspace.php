<?php
require_once __DIR__ . '/../DatabaseProvider.php';


class ProjectsInWorkspace {
    private int $id;
    private int $project_id;
    private int $workspace_id;
    private int $position;

    public function __construct(int $id, int $project_id, int $workspace_id, int $position) {
        $this->setId($id);
        $this->setProjectId($project_id);
        $this->setWorkspaceId($workspace_id);
        $this->setPosition($position);
    }

    // SQL Queries

    public static function deleteById(int $id): bool {
        return DatabaseProvider::query("DELETE FROM projects_in_workspaces WHERE `id` = $id;");
    }

    public static function getAllByWorkspaceId(int $id): array {
        $ret = array();
        $result = DatabaseProvider::query("SELECT * FROM projects_in_workspaces WHERE `workspace_id` = $id ORDER BY `position`;");
        if ($result->num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new ProjectsInWorkspace(
                    $row['id'],
                    $row['project_id'],
                    $row['workspace_id'],
                    $row['position']
                );
            }
        }
        return $ret;
    }

    public static function getById(int $id): ?ProjectsInWorkspace {
        $result = DatabaseProvider::query("SELECT * FROM projects_in_workspaces WHERE `id` = $id;");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new ProjectsInWorkspace(
                $row['id'],
                $row['project_id'],
                $row['workspace_id'],
                $row['position']
            );
        }
        return null;
    }

    public static function insert(ProjectsInWorkspace $piw): bool {
        return DatabaseProvider::query(
            "INSERT INTO projects_in_workspaces (`id`, `project_id`, `workspace_id`, `position`) VALUES ($piw->id,
                                                                   $piw->project_id, $piw->workspace_id, $piw->position);"
        );
    }

    public static function update(ProjectsInWorkspace $piw): bool {
        return DatabaseProvider::query(
            "UPDATE projects_in_workspaces SET `project_id` = $piw->project_id, `workspace_id` = $piw->workspace_id,
                                  `position` = $piw->position WHERE `id` = $piw->id;"
        );
    }

    // Getters and setters

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPosition(): int {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getProjectId(): int {
        return $this->project_id;
    }

    /**
     * @return int
     */
    public function getWorkspaceId(): int {
        return $this->workspace_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void {
        $this->position = $position;
    }

    /**
     * @param int $project_id
     */
    public function setProjectId(int $project_id): void {
        $this->project_id = $project_id;
    }

    /**
     * @param int $workspace_id
     */
    public function setWorkspaceId(int $workspace_id): void {
        $this->workspace_id = $workspace_id;
    }
}