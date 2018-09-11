<?php namespace NickAguilarH\Fortress\Contracts;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package NickAguilarH\Fortress
 */

interface FortressOrganizationInterface
{
    /**
     * Many-to-Many relations with User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users();

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
}
