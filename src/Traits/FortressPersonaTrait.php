<?php namespace NickAguilarH\Fortress\Traits;

use Illuminate\Support\Facades\Cache;
use NickAguilarH\Fortress\Models\Role;
use Ramsey\Uuid\Uuid;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package NickAguilarH\Fortress
 */
trait FortressPersonaTrait
{
    /**
     * Boot the permission model
     * Attach event listener to remove the many-to-many records when trying to delete
     * Will NOT delete any records if the permission model uses soft deletes.
     *
     * @return void|bool
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($persona) {
            if (!method_exists(config('fortress.persona'), 'bootSoftDeletes')) {
                $persona->roles()->sync([]);
                $persona->perms()->sync([]);
            }
            return true;
        });

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    /**
     * Many-to-Many relations with role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('fortress.role'), config('fortress.persona_role_table'),
            config('fortress.persona_foreign_key'), config('fortress.role_foreign_key'));
    }

    /**
     * Many-to-Many relations with the personae model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perms()
    {
        return $this->belongsToMany(config('fortress.permission'), config('fortress.persona_permission_table'),
            config('fortress.persona_foreign_key'), config('fortress.permission_foreign_key'));
    }

    /**
     * MorphTo relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function personable()
    {
        return $this->morphTo(null, config('fortress.personable_column'), config('fortress.personable_foreign'));
    }

    /**
     * BelongsTo relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('fortress.user'));
    }

    /**
     * Checks if the user has a role by its name.
     *
     * @param string|array $name Role name or array of role names.
     * @param bool $requireAll All roles in the array are required.
     *
     * @return bool
     */
    public function hasRole($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the roles were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the roles were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            if (is_object($name)) {
                foreach ($this->cachedRoles() as $role) {
                    if ($role->name == $name->name) {
                        return true;
                    }
                }
            } else {
                foreach ($this->cachedRoles() as $role) {
                    if ($role->name == $name) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Big block of caching functionality.
     *
     * @return mixed Roles
     */
    public function cachedRoles()
    {
        $personaPrimaryKey = $this->primaryKey;
        $cacheKey = 'fortress_roles_for_persona_' . $this->$personaPrimaryKey;
        if (Cache::getStore() instanceof TaggableStore) {
            return Cache::tags(config('fortress.persona_role_table'))->remember($cacheKey, config('cache.ttl'),
                function () {
                    return $this->roles()->get();
                });
        } else {
            return $this->roles()->get();
        }
    }

    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission Permission string or array of permissions.
     * @param bool $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function hasPerm($permission, $requireAll = false)
    {
        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $hasPerm = $this->hasPerm($permName);

                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            if (is_object($permission)) {
                foreach ($this->cachedRoles() as $role) {
                    if ($role->name == $permission->name) {
                        return true;
                    }
                }
            } else {
                foreach ($this->cachedPerms() as $perm) {
                    if (str_is($permission, $perm->name)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Big block of caching functionality.
     *
     * @return mixed Permissions
     */
    public function cachedPerms()
    {
        $personaPrimaryKey = $this->primaryKey;
        $cacheKey = 'fortress_permissions_for_persona_' . $this->$personaPrimaryKey;
        if (Cache::getStore() instanceof TaggableStore) {
            return Cache::tags(config('fortress.persona_permission_table'))->remember($cacheKey, config('cache.ttl'),
                function () {
                    return $this->perms()->get();
                });
        } else {
            return $this->perms()->get();
        }
    }

    /**
     * Attach multiple roles to a user
     *
     * @param mixed $roles
     *
     * @return bool
     */
    public function attachRoles($roles)
    {
        foreach ($roles as $role) {
            if (!$this->attachRole($role)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $role
     *
     * @return bool
     */
    public function attachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        } else if (is_array($role)) {
            $role = $role['uuid'];
        } else if (is_string($role)) {
            $role = config('fortress.role')::where('name', '=', $role)->first();
            $role = $role->uuid;
        }

        try {
            $this->roles()->sync($role, false);
            $this->parsePermsOfRole(config('fortress.role')::find($role));
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Assign default set of permissions of a specified role.
     *
     * @param Role $role
     * @param bool $remove
     */
    public final function parsePermsOfRole(Role $role, bool $remove = false): void
    {
        $perms = $role->perms;
        foreach ($perms as $perm) {
            if ($remove) {
                $this->detachPermission($perm);
            } else {
                $this->attachPermission($perm);
            }
        }
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $perm
     *
     * @return bool
     */
    public function detachPermission($perm)
    {
        if (is_object($perm)) {
            $perm = $perm->getKey();
        } else if (is_array($perm)) {
            $perm = $perm['uuid'];
        } else if (is_string($perm)) {
            $perm = config('fortress.permission')::where('name', '=', $perm)->first();
            $perm = $perm->uuid;
        }

        try {
            $this->perms()->detach($perm);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $perm
     *
     * @return bool
     */
    public function attachPermission($perm)
    {
        if (is_object($perm)) {
            $perm = $perm->getKey();
        } else if (is_array($perm)) {
            $perm = $perm['uuid'];
        } else if (is_string($perm)) {
            $perm = config('fortress.permission')::where('name', '=', $perm)->first();
            $perm = $perm->uuid;
        }

        try {
            $this->perms()->sync($perm, false);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Detach multiple roles from a user
     *
     * @param mixed $roles
     *
     * @return bool
     */
    public function detachRoles($roles)
    {
        if (!$roles) {
            $roles = $this->roles()->get();
        }

        foreach ($roles as $role) {
            if (!$this->detachRole($role)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $role
     *
     * @return bool
     */
    public function detachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        } else if (is_array($role)) {
            $role = $role['uuid'];
        } else if (is_string($role)) {
            $role = config('fortress.role')::where('name', '=', $role)->first();
            $role = $role->uuid;
        }

        try {
            $this->roles()->detach($role);
            $this->parsePermsOfRole(config('fortress.role')::find($role), true);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Attach multiple roles to a user
     *
     * @param mixed $perms
     *
     * @return bool
     */
    public function attachPermissions($perms)
    {
        foreach ($perms as $perm) {
            if (!$this->attachPermission($perm)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Detach multiple roles from a user
     *
     * @param mixed $perms
     *
     * @return bool
     */
    public function detachPermissions($perms)
    {
        if (!$perms) {
            $perms = $this->perms()->get();
        }

        foreach ($perms as $perm) {
            if (!$this->detachPermission($perm)) {
                return false;
            }
        }
        return true;
    }

    /**
     *Filtering personae according to their role
     *
     * @param string $role
     *
     * @return personae collection
     */
    public function scopeWithRole($query, $role)
    {
        return $query->whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        });
    }

    /**
     *Filtering personae according to their perm
     *
     * @param string $perm
     *
     * @return personae collection
     */
    public function scopeWithPerm($query, $perm)
    {
        return $query->whereHas('perms', function ($query) use ($perm) {
            $query->where('name', $perm);
        });
    }
}
