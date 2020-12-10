<?php


namespace boisson\models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Ingredient
 * @package boisson\models
 */
class Ingredient extends Model
{
    protected $table = 'Ingredient';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * Function use to get the repice who use this ingredient
     * @return BelongsToMany
     */
    public function recettes()
    {
        return $this->belongsToMany(Recette::class, 'RecetteUse', 'id_ingredient', 'id_recette', 'id', 'id');
    }

    /**
     * Get the upper category
     * @return BelongsToMany
     */
    public function sub_categorys()
    {
        return $this->belongsToMany(Ingredient::class, 'Subcategory', 'id_ingredient_master', 'id_ingredient_slave', 'id', 'id');
    }

    /**
     * Get the lower category
     * @return BelongsToMany
     */
    public function sup_categorys()
    {
        return $this->belongsToMany(Ingredient::class, 'Supcategory', 'id_ingredient_master', 'id_ingredient_slave', 'id', 'id');
    }
}