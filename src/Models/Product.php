<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'id',
        'name',
        'category_id',
        'site_id',
        'param_one',
        'param_two',
        'param_three',
        'price_one',
        'price_two',
        'date_update'
    ];
    public $timestamps = false;
}