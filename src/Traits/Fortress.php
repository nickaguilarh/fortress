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
        return !!$persona ? $persona->hasRole($role) : false;
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
        return !!$persona ? $persona->hasPerm($perm) : false;
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
        return !!$persona ? $persona->attachRole($role) : false;
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
        return !!$persona ? $persona->detachRole($role) : false;
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
        return !!$persona ? $persona->attachRoles($roles) : false;
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
        return !!$persona ? $persona->detachRoles($roles) : false;
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
        return !!$persona ? $persona->attachPermission($role) : false;
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
        return !!$persona ? $persona->detachPermission($role) : false;
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
        return !!$persona ? $persona->attachPermissions($roles) : false;
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
        return !!$persona ? $persona->detachPermissions($roles) : false;
    }


    /**
     * @param null $personable
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|mixed|object|null
     */
    private function getPersona($personable = null)
    {
        /** @var \NickAguilarH\Fortress\Models\Persona $persona */
        if (!$personable) return $this->personae()->first();

        $persona = $this->personae()
            ->where(config('fortress.personable_column') . '_type', get_class($personable))
            ->where(config('fortress.personable_column') . '_id', $personable->id)->first();

        if (!$persona) {
            $persona = self::createPersona($personable);
        }

        return $persona;
    }

    private function createPersona($personable)
    {
        if (!is_object($personable)) {
            return false;
        }
        $persona = $this->personae()->newModelInstance();
        $persona->user()->associate($this);
        $persona->personable()->associate($personable);
        $persona->save();
        return $persona;
    }
}