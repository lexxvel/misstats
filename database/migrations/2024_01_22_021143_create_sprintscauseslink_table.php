<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSprintsCausesLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sprintscauseslink', function (Blueprint $table) {
            $table->id('Sprintscauseslink_id');
            $table->unsignedBigInteger('Sprint_id')->nullable();
            $table->unsignedBigInteger('User_id')->nullable();
            $table->unsignedBigInteger('Cause_id')->nullable();
            $table->integer('Cause_Failcount');
            $table->timestamps();
            $table->foreign('Sprint_id')
                ->references('Sprint_id')
                ->on('sprints')
                ->onDelete('cascade');
            $table->foreign('User_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('Cause_id')
                ->references('Cause_id')
                ->on('causes')
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
        Schema::dropIfExists('sprintscauseslink');
    }
}
