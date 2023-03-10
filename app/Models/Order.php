<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'qun',
        'product_id',
        'user_id',
        'g_id',
        'email',
        'password',
        'state'
    ];


    public function product(){

        return $this->belongsTo(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function paymentinfo(){
        return $this->belongsToMany(Paymentinfo::class,'order_paymentinfo');
    }
    public function paymentinfo_one(){
        return $this->paymentinfo()->first();
    }

    public function processe_token(){
        return $this->morphMany(Processetoken::class,'processe');
    }
    public function processe_token_one(){
        return $this->morphMany(Processetoken::class,'processe')->first();
    }


    public function total_price(){
        $total_price=$this->product->price * $this->qun;
        $dis_total_price= $total_price;
     //   $user=auth()->user();

       $offer=$this->product->hasOffer();
       if($offer!=null)
      {
       $dis_total_price=$offer->p_dic * $this->qun;
      }

    else{
       $role=$this->user->hasRole('تاجر');

         if($role==true)
       {
         $role_id=Role::where('name','=','تاجر')->pluck('id')->first();
      $dis_persint=Discount::whereHas('role',
         function (Builder $query)use($role_id){
            $query->where('id','=',$role_id);
              })->first();

               $dis_total_price= $total_price-($total_price*$dis_persint->dis_persint);
            }
      }
      return $dis_total_price;

    }




}
