<?php

use Smsapp\GroupsUser;
use Smsapp\Group;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Smsapp\Group::class, 10)->create()->each(function ($u) {
      $u->groupUsers()->save(factory(Smsapp\GroupsUser::class)->make());
      });
    }
}
