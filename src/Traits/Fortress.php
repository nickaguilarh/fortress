<?php


namespace NickAguilarH\Fortress\Traits;


trait Fortress
{
    public function personae()
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
        return $this->hasMany(config('fortress.persona'));
    }

    /**
     * @param $role
     * @param \NickAguilarH\Fortress\Models\Persona $personable
     * @return boolean
     */
    public function hasRole($role, $personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        if (!$personable) $persona = $this->personae()->first()->personable();

        $persona = $this->personae()
            ->where('persona_type', get_class($personable))
            ->where('persona_id', $personable->id)->first();

        $persona->hasRole($role);
        return false;
    }


    /**
     * @param $perm
     * @param \NickAguilarH\Fortress\Models\Persona $personable
     * @return boolean
     */
    public function hasPerm($perm, $personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        if (!$personable) $persona = $this->personae()->first()->personable();

        $persona = $this->personae()
            ->where('persona_type', get_class($personable))
            ->where('persona_id', $personable->id)->first();

        $persona->hasPerm($perm);
        return false;
    }
}