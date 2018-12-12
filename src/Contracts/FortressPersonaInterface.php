<?php namespace NickAguilarH\Fortress\Contracts;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package NickAguilarH\Fortress
 */

interface FortressPersonaInterface
{
    /**
     * MorphTo relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function personable();

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles();

    /**
     * Many-to-Many relations with Permission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perms();

    /**
     * Checks if the user has a role by its name.
     *
     * @param string|array $name       Role name or array of role names.
     * @param bool         $requireAll All roles in the array are required.
     *
     * @return bool
     */
    public function hasRole($name, $requireAll = false);

    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission Permission string or array of permissions.
     * @param bool         $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function can($permission, $requireAll = false);

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $role
     */
    public function attachRole($role);

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $role
     */
    public function detachRole($role);

    /**
     * Attach multiple roles to a user
     *
     * @param mixed $roles
     */
    public function attachRoles($roles);

    /**
     * Detach multiple roles from a user
     *
     * @param mixed $roles
     */
    public function detachRoles($roles);


    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $role
     */
    public function attachPermission($role);

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $role
     */
    public function detachPermission($role);

    /**
     * Attach multiple roles to a user
     *
     * @param mixed $roles
     */
    public function attachPermissions($roles);

    /**
     * Detach multiple roles from a user
     *
     * @param mixed $roles
     */
    public function detachPermissions($roles);
}
