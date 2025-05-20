<?php

namespace NickAguilarH\Fortress\Models;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package NickAguilarH\Fortress
 */

use Illuminate\Database\Eloquent\Model;
use NickAguilarH\Fortress\Contracts\FortressRoleInterface;
use NickAguilarH\Fortress\Traits\FortressRoleTrait;

class Role extends Model implements FortressRoleInterface
{
    use FortressRoleTrait;

    /**
     * The primary key for the model no autoincrement.
     *
     * @var boolean
     */
    public $incrementing = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';


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
