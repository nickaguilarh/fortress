<?php 

namespace NickAguilarH\Fortress\Traits;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package NickAguilarH\Fortress
 */

use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

trait FortressRoleTrait
{
    //Big block of caching functionality.
    /**
     * Boot the role model
     * Attach event listener to remove the many-to-many records when trying to delete
     * Will NOT delete any records if the role model uses soft deletes.
     *
     * @return void|bool
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($role) {
            if (!method_exists(config('fortress.role'), 'bootSoftDeletes')) {
                $role->personae()->sync([]);
                $role->perms()->sync([]);
            }

            return true;
        });

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    /**
     * Many-to-Many relations with the personae model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function personae()
    {
        return $this->belongsToMany(config('fortress.persona'), config('fortress.persona_role_table'), config('fortress.role_foreign_key'), config('fortress.persona_foreign_key'));
    }

    /**
     * Many-to-Many relations with the permission model.
     * Named "perms" for backwards compatibility. Also because "perms" is short and sweet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perms()
    {
        return $this->belongsToMany(config('fortress.permission'), config('fortress.permission_role_table'), config('fortress.role_foreign_key'), config('fortress.permission_foreign_key'));
    }

    public function cachedPermissions()
    {
        $rolePrimaryKey = $this->primaryKey;
        $cacheKey = 'fortress_permissions_for_role_' . $this->$rolePrimaryKey;
        if (Cache::getStore() instanceof TaggableStore) {
            return Cache::tags(config('fortress.permission_role_table'))->remember($cacheKey, config('cache.ttl', 60), function () {
                return $this->perms()->get();
            });
        } else return $this->perms()->get();
    }

    public function save(array $options = [])
    {   //both inserts and updates
        if (!parent::save($options)) {
            return false;
        }
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(config('fortress.permission_role_table'))->flush();
        }
        return true;
    }

    public function delete(array $options = [])
    {   //soft or hard
        if (!parent::delete($options)) {
            return false;
        }
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(config('fortress.permission_role_table'))->flush();
        }
        return true;
    }

    public function restore()
    {   //soft delete undo's
        if (!parent::restore()) {
            return false;
        }
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(config('fortress.permission_role_table'))->flush();
        }
        return true;
    }

    /**
     * Save the inputted permissions.
     *
     * @param mixed $inputPermissions
     *
     * @return void
     */
    public function savePermissions($inputPermissions)
    {
        if (!empty($inputPermissions)) {
            $this->perms()->sync($inputPermissions);
        } else {
            $this->perms()->detach();
        }

        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(config('fortress.permission_role_table'))->flush();
        }
    }

    /**
     * Attach permission to current role.
     *
     * @param object|array $permission
     *
     * @return void
     */
    public function attachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }

        if (is_array($permission)) {
            return $this->attachPermissions($permission);
        }

        $this->perms()->attach($permission);
    }

    /**
     * Attach multiple permissions to current role.
     *
     * @param mixed $permissions
     *
     * @return void
     */
    public function attachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->attachPermission($permission);
        }
    }

    /**
     * Detach permission from current role.
     *
     * @param object|array $permission
     *
     * @return void
     */
    public function detachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }

        if (is_array($permission)) {
            return $this->detachPermissions($permission);
        }

        $this->perms()->detach($permission);
    }

    /**
     * Detach multiple permissions from current role
     *
     * @param mixed $permissions
     *
     * @return void
     */
    public function detachPermissions($permissions = null)
    {
        if (!$permissions) $permissions = $this->perms()->get();

        foreach ($permissions as $permission) {
            $this->detachPermission($permission);
        }
    }
}
