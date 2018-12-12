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
     * Many-to-Many relations with the persona model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function personae();
}
