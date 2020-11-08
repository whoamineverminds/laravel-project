<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->integer('list_id', false, true);
            $table->foreign('list_id')
                ->references('id')
                ->on('to_do_lists')
                ->onDelete('cascade');;
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
