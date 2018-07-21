<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCaloriesToShow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shows', function (Blueprint $table) {
            $table->unsignedInteger('calories');
            $table->dropColumn('run_time_in_minutes');
            $table->string('runtime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shows', function (Blueprint $table) {
            $table->dropColumn('calories');
            $table->dropColumn('runtime');
            $table->unsignedInteger('run_time_in_minutes');
        });
    }
}
