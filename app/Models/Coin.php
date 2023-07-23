<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;

   protected $fillable=[
        'name','nickname','icon','main_coin',
        'value'
    ];


    function froms() {
        return $this->hasMany(CoinValue::class,'from_coin_id','id');
    }
    function tos() {
        return $this->hasMany(CoinValue::class,'to_coin_id','id');
    }


    function trans_to_coin($coin_id=1,$amount=0) {

//        $coinfrom=$this->forms()->where('')->first();
        $value=CoinValue::where('from_coin_id','=',$coin_id)
        ->where('to_coin_id','=',$this->id)->pluck('value')->first();
        return $amount*$value;
    }


    function trans_from_coin($coin_id=1,$amount=0) {

        //        $coinfrom=$this->forms()->where('')->first();
                $value=CoinValue::where('from_coin_id','=',$coin_id)
                ->where('to_coin_id','=',$this->id)->pluck('value')->first();
                return $amount/$value;
            }
}


