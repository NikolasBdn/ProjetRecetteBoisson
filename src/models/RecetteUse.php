<?php


namespace boisson\models;


use Illuminate\Database\Eloquent\Model;

class RecetteUse extends Model
{
    protected $table = 'RecetteUse';
    public $timestamps = false;

    public function ingredients()
    {
        return $this->hasMany('boisson\models\Ingredient','id', 'id_ingredient');
    }
}