<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayMenu extends Model
{
    use HasFactory;
    protected $fillable = ['day_id', 'menu_id'];

    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }
    public function day(){
        return $this->belongsTo('App\Models\Day');
    }
}
