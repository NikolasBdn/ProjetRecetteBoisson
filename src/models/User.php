<?php


namespace boisson\models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'User';
    protected $primaryKey = 'username';
    public $timestamps = false;

    public function basket()
    {
        return $this->belongsToMany(Recette::class, 'basket', 'username', 'recipe', 'username', 'id');
    }
}