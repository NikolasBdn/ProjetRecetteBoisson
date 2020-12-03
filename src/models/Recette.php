<?php


namespace boisson\models;


use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    protected $table = 'Recette';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'RecetteUse', 'id_recette', 'id_ingredient', 'id', 'id');
    }
}