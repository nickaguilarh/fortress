<?php namespace NickAguilarH\Fortress\Contracts;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package NickAguilarH\Fortress
 */

interface FortressPermissionInterface
{

    /**
     * Many-to-Many relations with role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles();

    /**
     * TODO: Implement get users as needed.
     *
     * @return mixed
     */
    // public function users();
}
