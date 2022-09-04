<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CategoryProperty extends Model
{
    protected $table = 'category_property';
    protected $fillable = [
        'category_id',
        'type'
    ];
    public $timestamps = false;
}