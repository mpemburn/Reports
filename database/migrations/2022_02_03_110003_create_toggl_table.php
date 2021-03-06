<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTogglTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toggl', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('public_id');
            $table->bigInteger('uid');
            $table->string('ticket_id');
            $table->string('description');
            $table->string('duration');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->softDeletes();
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
        Schema::dropIfExists('toggl');
    }
}
