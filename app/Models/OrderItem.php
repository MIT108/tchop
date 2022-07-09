<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'pack_id', 'amount', 'quantity'];
    public function pack(){
        return $this->belongsTo('App\Models\Pack');
    }
    public function order(){
        return $this->belongsTo('App\Models\Order');
    }
}
