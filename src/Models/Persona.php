<?php

namespace NickAguilarH\Fortress\Models;

use Illuminate\Database\Eloquent\Model;
use NickAguilarH\Fortress\Contracts\FortressPersonaInterface;
use NickAguilarH\Fortress\Traits\FortressPersonaTrait;

class Persona extends Model implements FortressPersonaInterface
{
    use FortressPersonaTrait;

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
        $this->table = config('fortress.persona_table');
    }
}
