<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

final class Users extends Migration
{
    public function up(){
        $this->schema->create('users',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('login',256);
            $table->string('password',256);
        });

        $user = [
            'login' => 'admin_user',
            'password' => md5('test123')
        ];

        Capsule::table('users')->insert($user);
    }

    public function down()
    {
        $this->schema->drop('users');
    }
}
