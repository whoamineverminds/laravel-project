<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateToDoPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('to_do_plans', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('list_id', false, true);
            $table->foreign('list_id')
                ->references('id')
                ->on('to_do_lists')
                ->onDelete('cascade');
            $table->string('title', 32);
            $table->text('description')->nullable();
            $table->smallInteger('priority', false, true);
            $table->boolean('complete')->default(false);
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
        Schema::dropIfExists('plans');
    }
}
