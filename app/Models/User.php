<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
class User extends Authenticatable implements BannableContract
{
    use HasApiTokens, HasFactory,HasRoles, Notifiable, Bannable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'phone',
        'gendar',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


   // $user->orders()->
  public  function orders(){
        return $this->hasMany(Order::class);
    }


    public function rassed(){
        return $this->hasOne(Rassed::class);
    }

    public function rassedy(){
        return $this->rassed->actevities()->sum('amount');
    }



    public function order_products(){
        return $this->belongsToMany(Product::class,
        Order::class)->distinct();
    }



    public function acivites_groupByDate(){


        $acivites=$this->rassed->actevities()->get()
         ->groupBy(
             function($date){
               return Carbon::parse($date->created_at)->format('Y-m-d'); // grouping by months

             }
         );


         $oac=[];
         foreach($acivites as $k=>$v){

            $oac[]=[
                "date"=>$k,
                "actevities"=>$v
            ];

         }

        return array_reverse($oac);


    }

   public function orders_gr(){
       $orders= $this->orders()->has('paymentinfo')->with('paymentinfo')->get()
       ->groupBy(
            function($data){
              return  $data->paymentinfo->first()->id;
            }
        );


        $order_gruopBy=[];

        foreach($orders as $key=>$value){
            $order_gruopBy[]=[
                "id"=>$key,
                "orders"=>$value,
                "paymentinfo"=>$value[0]["paymentinfo"][0]
                //Paymentinfo::where("id","=",$key)->first()
            ];
        }

       return array_reverse($order_gruopBy);

    }

    function f_token(){
        return $this->hasOne(FirebaseToken::class);
    }
}
