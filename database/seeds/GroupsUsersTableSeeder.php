<?php

use Smsapp\GroupsUser;
use Smsapp\Group;
use Illuminate\Database\Seeder;

class GroupsUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Smsapp\GroupsUser::class, 10)->create()->each(function ($u) {
        $u->userGroups()->save(factory(Smsapp\Group::class)->make());
        });
    }
}
