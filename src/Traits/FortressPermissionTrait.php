<?php 

namespace NickAguilarH\Fortress\Traits;

use Ramsey\Uuid\Uuid;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package NickAguilarH\Fortress
 */
trait FortressPermissionTrait
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

        static::deleting(function ($permission) {
            if (!method_exists(config('fortress.permission'), 'bootSoftDeletes')) {
                $permission->roles()->sync([]);
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
        return $this->belongsToMany(config('fortress.role'), config('fortress.permission_role_table'), config('fortress.permission_foreign_key'), config('fortress.role_foreign_key'));
    }

    /**
     * Many-to-Many relations with the personae model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function personae()
    {
        return $this->belongsToMany(config('fortress.persona'), config('fortress.persona_permission_table'), config('fortress.permission_foreign_key'), config('fortress.persona_foreign_key'));
    }
}
