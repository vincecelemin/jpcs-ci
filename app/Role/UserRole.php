<?php

namespace App\Role;

/***
 * Class UserRole
 * @package App\Role
 */
class UserRole {

    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_AUTHOR = 'ROLE_AUTHOR';
    const ROLE_CONTENT_MANAGER = 'CONTENT_MANAGER';

    /**
     * @var array
     */
    protected static $roleHierarchy = [
        self::ROLE_ADMIN => ['*'],
        self::ROLE_AUTHOR => [],
        self::ROLE_CONTENT_MANAGER => []
    ];

    /**
     * @param string $role
     * @return array
     */
    public static function getAllowedRoles(string $role)
    {
        if (isset(self::$roleHierarchy[$role])) {
            return self::$roleHierarchy[$role];
        }

        return [];
    }

    /***
     * @return array
     */
    public static function getRoleList()
    {
        return [
            static::ROLE_ADMIN =>'System Administrator',
            static::ROLE_AUTHOR => 'Publication Author',
            static::ROLE_CONTENT_MANAGER => 'Site Content Manager',
        ];
    }

    /***
     * @return array
     */
    public static function getRoleListAndDescription()
    {
        return [
            static::ROLE_ADMIN =>['role' => 'System Administrator', 'description' => 'Responsible for managing the users and content encompassing the system'],
            static::ROLE_AUTHOR => ['role' => 'Publication Author', 'description' => 'Publishes newsletters for the visitors\'s view'],
            static::ROLE_CONTENT_MANAGER => ['role' => 'Site Content Manager', 'description' => 'Manages variables existing on the public website ranging from images up to the organization\'s core information'] ,
        ];
    }
}