<?php namespace NickAguilarH\Fortress\Models;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package NickAguilarH\Fortress
 */

use NickAguilarH\Fortress\Contracts\FortressRoleInterface;
use NickAguilarH\Fortress\Traits\FortressRoleTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model implements FortressRoleInterface
{
    use FortressRoleTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('fortress.roles_table');
    }
}
