<?php

namespace NickAguilarH\Fortress\Models;

use Illuminate\Database\Eloquent\Model;
use NickAguilarH\Fortress\Contracts\FortressPersonaInterface;
use NickAguilarH\Fortress\Traits\FortressPersonaTrait;

class Persona extends Model implements FortressPersonaInterface
{
    use FortressPersonaTrait;

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
        $this->table = config('fortress.persona_table');
    }
}
