<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Day extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image', 'description'];
    public function getImageAttribute($value){
        return env('APP_URL').Storage::url("days/".$value);
    }

    public function day_menu(){
        return $this->hasMany('App\Model\DayMenu');
    }
}
