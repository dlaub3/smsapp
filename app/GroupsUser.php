<?php

namespace Smsapp;

use Illuminate\Database\Eloquent\Model;

class GroupsUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['group_id', 'name', 'phone_number', 'is_admin_approved'];

    /**
     * Get the group for this group user.
     */
    public function userGroups()
    {
        return $this->belongsTo('Smsapp\Group', 'group_id');
    }
}
