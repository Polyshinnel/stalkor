<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class CategoryProperty extends Migration
{
    public function up(){
        $this->schema->create('category_property',function (Blueprint $table){
            $table->BigInteger('category_id')->unsigned();
            $table->BigInteger('type')->unsigned();
        });
    }

    public function down()
    {
        $this->schema->drop('category_property');
    }
}
