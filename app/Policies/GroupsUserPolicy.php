<?php

namespace Smsapp\Policies;

use Smsapp\User;
use Smsapp\Group;
use Smsapp\GroupsUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupsUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the groupsUser.
     *
     * @param  \Smsapp\User  $user
     * @param  \Smsapp\GroupsUser  $groupsUser
     * @return mixed
     */
    public function deleteAffiliation(User $user, GroupsUser $groupsUser)
    {
        return $groupsUser->phone_number === $user->phone_number;
    }

    /**
     * Determine whether the user can delete the groupsUser.
     *
     * @param  \Smsapp\User  $user
     * @param  \Smsapp\GroupsUser  $groupsUser
     * @return mixed
     */
    public function crud(User $user, GroupsUser $groupsUser)
    {
        $id = $groupsUser->id;
        $id = $user->groupsUsers()->findOrFail($id);
        return $groupsUser->id === $id->id;
    }
}
