<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_users', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('group_id')
            ->unsigned();
            $table->foreign('group_id')
            ->references('id')->on('groups')
            ->onDelete('cascade');

            $table->string('name');
            $table->string('phone_number');
            $table->boolean('is_sms_activated')->default(0);
            $table->boolean('is_admin_approved')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups_users');
    }
}
