<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paths', function (Blueprint $table) {
            $table->string('session_id', 40);
            $table->timestamps();
            $table->string('url', 20);
            $table->double('loading_time', 6, 3);
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
        Schema::drop('paths');
    }
}
