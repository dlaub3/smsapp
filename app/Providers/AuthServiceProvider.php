<?php

namespace Smsapp\Providers;

use Smsapp\Group;
use Smsapp\GroupsUser;
use Smsapp\Policies\GroupPolicy;
use Smsapp\Policies\GroupsUserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Smsapp\Model' => 'Smsapp\Policies\ModelPolicy',
        Group::class => GroupPolicy::class,
        GroupsUser::class => GroupsUserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
