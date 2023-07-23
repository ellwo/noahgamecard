<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinValue extends Model
{
    use HasFactory;






    function to_coin(){
        return $this->belongsTo(Coin::class,'to_coin_id');
    }
    function from_coin(){
        return $this->belongsTo(Coin::class,'from_coin_id');
    }
}
