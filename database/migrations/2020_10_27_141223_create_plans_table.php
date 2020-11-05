<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('list_id', false, true);
            $table->foreign('list_id')
                ->references('id')
                ->on('lists')
                ->onDelete('cascade');;
            $table->char('title', 32);
            $table->text('description')->nullable();
            $table->smallInteger('priority', false, true);
            $table->boolean('complete');
            $table->timestamp('date_create')->nullable();
            $table->timestamp('date_change')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
