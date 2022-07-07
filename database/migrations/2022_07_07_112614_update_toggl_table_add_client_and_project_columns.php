<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTogglTableAddClientAndProjectColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('toggl', function (Blueprint $table) {
            $table->string('ticket_id')->nullable()->change();
            $table->string('client')->nullable()->default(null)->after('ticket_id');
            $table->string('project')->nullable()->default(null)->after('client');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('toggl', function (Blueprint $table) {
            $table->dropColumn('client');
            $table->dropColumn('project');
        });

    }
}
