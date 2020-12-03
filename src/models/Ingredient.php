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

    public function sub_categorys()
    {
        return $this->belongsToMany(Ingredient::class, 'Subcategory', 'id_ingredient_master', 'id_ingredient_slave', 'id', 'id');
    }

    public function sup_categorys()
    {
        return $this->belongsToMany(Ingredient::class, 'Supcategory', 'id_ingredient_master', 'id_ingredient_slave', 'id', 'id');
    }
}