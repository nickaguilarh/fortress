<?php


namespace NickAguilarH\Fortress\Traits;


trait HasUsersWithPerms
{
    /**
     * Get the persona associated with this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany;
     */
    public function personae()
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
        return $this->morphMany(config('fortress.persona'), 'personable');
    }

}