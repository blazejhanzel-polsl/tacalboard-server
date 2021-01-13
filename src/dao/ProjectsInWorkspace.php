<?php


class ProjectsInWorkspace {
    private int $id;
    private int $project_id;
    private int $workspace_id;
    private int $position;

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