<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TypeList extends Model
{
    protected $table = 'type_list';
    protected $fillable = [
        'id',
        'column_one',
        'column_two',
        'column_three'
    ];
    public $timestamps = false;
}