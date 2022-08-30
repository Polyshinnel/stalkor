<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class TypeList extends Migration
{
    public function up(){
        $this->schema->create('type_list',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('column_one',127);
            $table->string('column_two',127);
            $table->string('column_three',127);
        });
    }

    public function down()
    {
        $this->schema->drop('type_list');
    }
}
