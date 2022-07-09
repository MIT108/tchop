<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pack extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image', 'unitPrice'];

    public function getImageAttribute($value){
        return env('APP_URL').Storage::url("packs/".$value);
    }

    public function menu_content(){
        return $this->hasMany('App\Model\PackContent');
    }
}
