<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id('Person_id');
            $table->string('Person_Name');
            $table->string('Person_Secname');
            $table->string('Person_Surname');
            $table->string('Person_Fullname');
            $table->string('Person_Email');
            $table->integer('Person_TableId')->nullable();
            $table->unsignedBigInteger('Person_PostId')->nullable();
            $table->integer('Person_Failcount')->nullable();
            $table->timestamps();
            $table->foreign('Person_PostId')
                ->references('Post_id')
                ->on('posts')
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
        Schema::dropIfExists('persons');
    }
}
