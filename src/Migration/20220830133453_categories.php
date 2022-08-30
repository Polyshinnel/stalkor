<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class Categories extends Migration
{
    public function up(){
        $this->schema->create('categories',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->integer('parent');
        });
    }

    public function down()
    {
        $this->schema->drop('categories');
    }
}
