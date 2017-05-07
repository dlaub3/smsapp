<?php

namespace Smsapp\Policies;

use Smsapp\User;
use Smsapp\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the group.
     *
     * @param  \Smsapp\User $user
     * @param  \Smsapp\Group $group
     * @return mixed
     */
    public function crud(User $user, Group $group)
    {
        return $user->id === $group->user_id;
    }
}
