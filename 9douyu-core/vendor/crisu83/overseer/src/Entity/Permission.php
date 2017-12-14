<?php namespace Crisu83\Overseer\Entity;

use Crisu83\Overseer\Exception\PropertyNotValid;

class Permission
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $resourceName;

    /**
     * @var array
     */
    private $rules;


    /**
     * Permission constructor.
     *
     * @param string      $permissionName
     * @param string|null $resourceName
     * @param array       $rules
     */
    public function __construct($permissionName, $resourceName = null, array $rules = [])
    {
        $this->setName($permissionName);
        $this->setResourceName($resourceName);
        $this->setRules($rules);
    }


    /**
     * @param string $ruleName
     *
     * @throws \Crisu83\Overseer\Exception\PropertyNotValid
     */
    public function addRule($ruleName)
    {
        if ($this->hasRule($ruleName)) {
            throw new PropertyNotValid('Rule already exists.');
        }
        $this->rules[] = $ruleName;
    }


    /**
     * @return bool
     */
    public function hasRules()
    {
        return !empty($this->rules);
    }


    /**
     * @param string $ruleName
     *
     * @return bool
     */
    private function hasRule($ruleName)
    {
        return in_array($ruleName, $this->rules);
    }


    /**
     * @param Resource $resource
     *
     * @return bool
     */
    public function appliesToResource(Resource $resource)
    {
        return $this->resourceName === $resource->getResourceName();
    }


    /**
     * @param Subject  $subject
     * @param Resource $resource
     * @param array    $params
     *
     * @return bool
     */
    public function evaluate(Subject $subject, Resource $resource, array $params)
    {
        if (!$this->hasRules()) {
            return true;
        }

        foreach ($this->rules as $className) {
            /** @var Rule $rule */
            $rule = new $className;
            if (!$rule->evaluate($subject, $resource, $params)) {
                return false;
            }
        }

        return true;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param string $name
     */
    private function setName($name)
    {
        if (empty($name)) {
            throw new PropertyNotValid('Permission name cannot be empty.');
        }

        $this->name = $name;
    }


    /**
     * @param string $resourceName
     */
    private function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;
    }


    /**
     * @param Rule[] $rules
     */
    private function setRules($rules)
    {
        $this->rules = $rules;
    }
}
