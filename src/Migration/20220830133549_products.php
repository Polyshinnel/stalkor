<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class Products extends Migration
{
    public function up(){
        $this->schema->create('products',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name',256);
            $table->BigInteger('category_id');
            $table->string('site_id',256);
            $table->string('param_one',256)->nullable();
            $table->string('param_two',256)->nullable();
            $table->string('param_three',256)->nullable();
            $table->string('price_one',256)->nullable();
            $table->string('price_two',256)->nullable();
            $table->dateTime('date_update');
        });
    }

    public function down()
    {
        $this->schema->drop('products');
    }
}
