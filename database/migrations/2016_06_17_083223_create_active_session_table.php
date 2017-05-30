<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_sessions', function (Blueprint $table)
        {
            $table->string('session_id', 40);
            $table->timestamps();
            $table->timestamp('end_time')->nullable();
            $table->integer('total_time')->nullable();
            $table->primary(['session_id', 'created_at']);
        });

        DB::unprepared('CREATE TRIGGER insert_total_time BEFORE UPDATE
                        ON active_sessions
                        FOR EACH ROW
                        BEGIN
                        SET
                        new.total_time = UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(NEW.created_at);
                        END;'
                        );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('active_sessions');
    }
}
