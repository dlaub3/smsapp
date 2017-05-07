<?php

namespace Smsapp\Repositories;

use Smsapp\User;
use Smsapp\Group;
use Smsapp\GroupsUser;

class GroupRepository
{
    /**
     * Get all of the groups for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function withGroups(User $user)
    {
        return Group::where('user_id', $user->id)
                      ->orderBy('name', 'asc')
                      ->get();
    }


    /**
     * Get all of the group users for a given group.
     *
     * @param  Group  $group
     * @return Collection
     */
    public function withUsers($group)
    {
        return Group::where('id', $group->id)
                    ->with(['groupUsers' => function ($query) {
                        $query->orderBy('is_admin_approved', 'asc');
                    }])
                    ->get();
    }

    /**
     * Get all of the affiliactions for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
     public function forAffiliations(User $user)
     {
         return GroupsUser::where('phone_number', $user->phone_number)
                       ->with(['userGroups' => function ($query) {
                           $query->orderBy('name', 'asc');
                       }])
                       ->get();
     }
}
