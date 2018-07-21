<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeItemShowPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_item_show', function (Blueprint $table) {
            $table->uuid('recipe_item_id')->index();
            $table->foreign('recipe_item_id')->references('id')->on('recipe_items');
            $table->uuid('show_id')->index();
            $table->foreign('show_id')->references('id')->on('shows');
            $table->primary(['recipe_item_id', 'show_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('recipe_item_show');
    }
}
