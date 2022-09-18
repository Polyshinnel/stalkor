<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class TelegramUsers extends Migration
{
    public function up(){
        $this->schema->create('telegram_users',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('phone',256);
            $table->string('telegram_id',256);
        });
    }

    public function down()
    {
        $this->schema->drop('telegram_users');
    }
}
