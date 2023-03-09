<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentinfo extends Model
{
    use HasFactory;
    protected $fillable=[
        'code',
        'paymentmethod_id',
        'prove_img',
        'mount_pay'
        ,'total_price',
        'state' ,//sate 0 not view by admin, 1 view and prosses,2succesfullay ,3 daney
        "accepted"
    ];


   public function orders(){
        return $this->belongsToMany(Order::class,'order_paymentinfo');
    }

    public function paymentmethod(){
        return $this->belongsTo(Paymentmethod::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }


    public function orginal_total(){

        $total=0.0;
        foreach($this->orders as $or){
            $total+=($or->product->price*$or->qun);
        }

        if($total!=0)
        return $total;
        else
        return $this->total_price;


    }


}
