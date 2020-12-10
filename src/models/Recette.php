<?php


namespace boisson\models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Recette
 * @package boisson\models
 */
class Recette extends Model
{
    protected $table = 'Recette';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * Function use to get the ingredients of a recipe
     * @return BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'RecetteUse', 'id_recette', 'id_ingredient', 'id', 'id');
    }
}