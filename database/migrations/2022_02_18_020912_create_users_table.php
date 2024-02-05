<?php

use App\Models\users;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('User_Login')->unique();
            $table->string('User_Name');
            $table->string('User_Password');
            $table->integer('User_Role_id');
            $table->rememberToken();
            $table->timestamps();
        });

        $data =  array(
            [
                'User_Login' => 'admin',
                'User_Name' => 'admin',
                'User_Password' => 'm09v3q3M8V53M4*$$%352@#$fer',
                'User_Role_id' => 10,
                'createdAt' => Carbon::now()
            ]);

        foreach ($data as $datum){
            $user = new users(); //The Category is the model for your migration
            $user->User_Login =$datum['User_Login'];
            $user->User_Name =$datum['User_Name'];
            $user->User_Password =$datum['User_Password'];
            $user->User_Role_id =$datum['User_Role_id'];
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
