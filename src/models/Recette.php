<?php


namespace boisson\models;


use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    protected $table = 'Recette';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function listIngredient()
    {
        return $this->hasMany('boisson\models\RecetteUse','id_recette')->with('ingredients');
    }
}