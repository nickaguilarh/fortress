<?php namespace NickAguilarH\Fortress;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package NickAguilarH\Fortress
 */

use NickAguilarH\Fortress\Contracts\FortressOrganizationInterface;
use NickAguilarH\Fortress\Traits\FortressOrganizationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class FortressOrganization extends Model implements FortressOrganizationInterface
{
    use FortressOrganizationTrait;

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
        $this->table = config('fortress.organizations_table');
    }

}
