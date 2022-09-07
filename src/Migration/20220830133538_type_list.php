<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;


final class TypeList extends Migration
{
    public function up(){
        $this->schema->create('type_list',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('column_one',127);
            $table->string('column_two',127);
            $table->string('column_three',127);
        });

        $typeList = [
            [
                'column_one' => 'Размер',
                'column_two' => 'Марка',
                'column_three' => 'Длина'
            ],
            [
                'column_one' => 'Размер',
                'column_two' => 'Марка',
                'column_three' => 'Поверхность'
            ],
            [
                'column_one' => 'Размер',
                'column_two' => 'Ру',
                'column_three' => 'Длина'
            ],
            [
                'column_one' => 'Размер',
                'column_two' => 'Секций',
                'column_three' => 'Длина'
            ],
            [
                'column_one' => 'Размер',
                'column_two' => 'Бренд',
                'column_three' => 'Примечание'
            ],
        ];

        foreach ($typeList as $typeUnit)
        {
            Capsule::table('type_list')->insert($typeUnit);
        }

    }

    public function down()
    {
        $this->schema->drop('type_list');
    }
}
