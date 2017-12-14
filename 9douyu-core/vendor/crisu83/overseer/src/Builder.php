<?php namespace Crisu83\Overseer;

use Crisu83\Overseer\Entity\Assignment;
use Crisu83\Overseer\Entity\Permission;
use Crisu83\Overseer\Entity\Role;

class Builder
{

    /**
     * @var Overseer
     */
    private $overseer;

    /**
     * @var array
     */
    private $config;


    /**
     * Builder constructor.
     *
     * @param Overseer $overseer
     * @param array    $config
     */
    public function __construct(Overseer $overseer, array $config)
    {
        $this->overseer = $overseer;
        $this->config   = $config;
    }


    /**
     * Build the assignments, roles and permissions based on configuration.
     */
    public function build()
    {
        $this->overseer->clearRoles();

        if (isset($this->config['roles'])) {
            $this->saveRoles($this->config['roles']);
        }

        $this->overseer->clearPermissions();

        if (isset($this->config['permissions'])) {
            $this->savePermissions($this->config['permissions']);
        }

        $this->overseer->clearAssignments();

        if (isset($this->config['assignments'])) {
            $this->saveAssignments($this->config['assignments']);
        }
    }


    /**
     * @param array $config
     */
    protected function saveRoles(array $config)
    {
        foreach ($config as $roleName => $roleConfig) {
            $this->overseer->saveRole(new Role(
                $roleName,
                isset($roleConfig['inherits']) ? $roleConfig['inherits'] : [],
                isset($roleConfig['permissions']) ? $roleConfig['permissions'] : []
            ));
        }
    }


    /**
     * @param array $config
     */
    protected function savePermissions(array $config)
    {
        foreach ($config as $permissionName => $permissionConfig) {
            $this->overseer->savePermission(new Permission(
                $permissionName,
                isset($permissionConfig['resource']) ? $permissionConfig['resource'] : null,
                isset($permissionConfig['rules']) ? $permissionConfig['rules'] : []
            ));
        }
    }


    /**
     * @param array $config
     */
    protected function saveAssignments(array $config)
    {
        foreach ($config as $subjectId => $assignmentConfig) {
            $this->overseer->saveAssignment(new Assignment(
                $subjectId,
                isset($assignmentConfig['subject_name']) ? $assignmentConfig['subject_name'] : null,
                isset($assignmentConfig['roles']) ? $assignmentConfig['roles'] : []
            ));
        }
    }
}
