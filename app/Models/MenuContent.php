<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuContent extends Model
{
    use HasFactory;
    protected $fillable = ['menu_id', 'ingredient_id'];

    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }
    public function ingredient(){
        return $this->belongsTo('App\Models\Ingredient');
    }
}
