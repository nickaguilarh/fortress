<?php


namespace NickAguilarH\Fortress\Traits;


trait HasUsersWithRoles
{
    /**
     * Get the persona associated with this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany;
     */
    public function persona()
    {
        return $this->morphMany(config('fortress.persona'), 'personable');
    }
}