<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ingredient extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image'];

    public function getImageAttribute($value){
        return env('APP_URL').Storage::url("ingredients/".$value);
    }

}
