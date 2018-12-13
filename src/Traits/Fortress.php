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
        $persona = self::getPersona($personable);
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
        $persona = self::getPersona($personable);
        $persona->hasPerm($perm);
        return false;
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $role
     * @param null $personable
     * @return mixed
     */
    public function attachRole($role, $personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        $persona = self::getPersona($personable);
        $persona->attachRole($role);
        return false;
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $role
     * @param null $personable
     * @return mixed
     */
    public function detachRole($role, $personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        $persona = self::getPersona($personable);
        $persona->detachRole($role);
        return false;
    }

    /**
     * Attach multiple roles to a user
     *
     * @param mixed $roles
     * @param null $personable
     * @return mixed
     */
    public function attachRoles($roles, $personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        $persona = self::getPersona($personable);
        $persona->attachRoles($roles);
        return false;
    }

    /**
     * Detach multiple roles from a user
     *
     * @param mixed $roles
     * @param null $personable
     * @return mixed
     */
    public function detachRoles($roles, $personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        $persona = self::getPersona($personable);
        $persona->detachRoles($roles);
        return false;
    }


    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $role
     * @param null $personable
     * @return mixed
     */
    public function attachPermission($role, $personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        $persona = self::getPersona($personable);
        $persona->attachPermission($role);
        return false;
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $role
     * @param null $personable
     * @return mixed
     */
    public function detachPermission($role, $personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        $persona = self::getPersona($personable);
        $persona->detachPermission($role);
        return false;
    }


    /**
     * Attach multiple roles to a user
     *
     * @param mixed $roles
     * @param null $personable
     * @return mixed
     */
    public function attachPermissions($roles, $personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        $persona = self::getPersona($personable);
        $persona->attachPermissions($roles);
        return false;
    }


    /**
     * Detach multiple roles from a user
     *
     * @param mixed $roles
     * @param null $personable
     * @return mixed
     */
    public function detachPermissions($roles, $personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        $persona = self::getPersona($personable);
        $persona->detachPermissions($roles);
        return false;
    }


    /**
     * @param null $personable
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|mixed|object|null
     */
    private function getPersona($personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        if (!$personable) return $this->personae()->first()->personable;

        return $this->personae()
            ->where(config('fortress.personable_column') . '_type', get_class($personable))
            ->where(config('fortress.personable_column') . '_id', $personable->id)->first();
    }
}