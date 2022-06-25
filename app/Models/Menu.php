<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image', 'description'];

    public function getImageAttribute($value){
        return env('APP_URL').Storage::url("menus/".$value);
    }
}
