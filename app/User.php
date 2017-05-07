<?php

namespace Smsapp;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone_number', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the groups created by this user.
     */
    public function groups()
    {
        return $this->hasMany('Smsapp\Group');
    }

    /**
     * Get the groups users for this user.
     */
    public function groupsUsers()
    {
        return $this->hasManyThrough('Smsapp\GroupsUser', 'Smsapp\Group');
    }
}
