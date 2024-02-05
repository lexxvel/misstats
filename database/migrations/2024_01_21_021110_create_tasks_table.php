<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('Task_id');
            $table->string('Task_Number');
            $table->float('Task_Plantime');
            $table->float('Task_Facttime')->nullable();
            $table->unsignedBigInteger('Task_Failcause')->nullable();
            $table->unsignedBigInteger('Task_Failperson')->nullable();
            $table->unsignedBigInteger('Task_SprintId');
            $table->timestamps();
            $table->foreign('Task_Failcause')
                ->references('Cause_id')
                ->on('causes')
                ->onDelete('cascade');
            $table->foreign('Task_SprintId')
                ->references('Sprint_id')
                ->on('sprints')
                ->onDelete('cascade');
            $table->foreign('Task_Failperson')
                ->references('Person_id')
                ->on('persons')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
