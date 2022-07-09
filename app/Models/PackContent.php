<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackContent extends Model
{
    use HasFactory;

    protected $fillable = ['pack_id', 'ingredient_id', 'quantity'];

    public function pack(){
        return $this->belongsTo('App\Models\Pack');
    }
    public function ingredient(){
        return $this->belongsTo('App\Models\Ingredient');
    }
}
