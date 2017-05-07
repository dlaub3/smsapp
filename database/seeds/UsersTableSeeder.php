<?php

use Smsapp\User;
use Smsapp\Group;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Smsapp\User::class, 10)->create()->each(function ($u) {
        $u->groups()->save(factory(Smsapp\Group::class)->make());
        });
    }
}
