<?php namespace NickAguilarH\Fortress;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package NickAguilarH\Fortress
 */

use NickAguilarH\Fortress\Contracts\FortressPermissionInterface;
use NickAguilarH\Fortress\Traits\FortressPermissionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class FortressPermission extends Model implements FortressPermissionInterface
{
    use FortressPermissionTrait;

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
        $this->table = config('fortress.permissions_table');
    }

}
