<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('session_id', 40);
            $table->timestamps();
            $table->string('ip', 15);
            $table->string('language', 6);
            $table->string('browser', 10);
            $table->string('os', 30);
            $table->string('nation', 15);
            $table->string('screen_resolution', 10);
            $table->primary(array('session_id', 'created_at'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
