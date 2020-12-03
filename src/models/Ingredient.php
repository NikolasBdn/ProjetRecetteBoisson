<?php


namespace boisson\models;


use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'Ingredient';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function recettes()
    {
        return $this->belongsToMany(Recette::class, 'RecetteUse', 'id_ingredient', 'id_recette', 'id', 'id');
    }
}