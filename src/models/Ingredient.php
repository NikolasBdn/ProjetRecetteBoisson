<?php


namespace boisson\models;


use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'Ingredient';
    protected $primaryKey = 'id';
    public $timestamps = false;
}