<?php

namespace Smsapp;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use Searchable;

      /**
       * Get the route key for the model.
       *
       * @return string
       */
      public function getRouteKeyName()
      {
          return 'slug';
      }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * Get the user who created the group.
     */
    public function groupAdmin()
    {
        return $this->belongsTo('Smsapp\User', 'user_id');
    }

    /**
     * Get the group users for this group.
     */
    public function groupUsers()
    {
        return $this->hasMany('Smsapp\GroupsUser');
    }
}
