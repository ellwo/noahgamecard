<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
class RassedActevity extends Model
{
    use HasFactory;
    use Loggable;
    protected $fillable=[
        'paymentinfo_id',
        'rassed_id',
        'amount','camount',
        'code',
        'coin_id'
    ];




    function coin() {

        return $this->belongsTo(Coin::class);
    }

    function scopeAccepted($query){


        return $query->whereHas('paymentinfo',function($q){
               return $q->where('state','=',2)->orWhere('state','=',1);
        });
    }
    function paymentinfo(){
        return $this->belongsTo(Paymentinfo::class);
    }

    function rassed(){
        return $this->belongsTo(Rassed::class);
    }



}
