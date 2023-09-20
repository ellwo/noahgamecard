<?php

namespace App\Models;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory,LaravelSubQueryTrait;

    use Loggable;
    public $fillable=[
        'name',
        'note',
        'img',
        'imgs',
        'discrip',
        'price',
        'required_ep',
        'user_id',
        'department_id'
    ];

    protected $casts =[
        'note'=>'array',
        'imgs'=>'array',
    ];


   public function countoforders(){
    return 0;
   }
    public function category()
    {
        return $this->belongsTo(Category::class);        # code...
    }
public function department()
{
    return $this->belongsTo(Department::class);
    # code...
}

       
    



public function provider_products()
{
    return $this->hasMany(ProviderProduct::class);
}
public function provider_product_first()
{
    return $this->provider_products()
    ->whereHas('client_provider',function($q){
        $q->whereHas('active_departments',function($qq){
            $qq->where('id','=',$this->department_id);
        });
    });
    # code...
}

public function provider_product()
{
    return $this->provider_products()
    ->where('active','=',1);
    # code...
}

 public function hasOffer(){
    return $this->hasMany(Offer::class)->where('to_date','>',now())->first();
 }

 public function offers(){
    return $this->hasMany(Offer::class)->where('to_date','>',now());
 }


    public function notes(){




        if(count($this->note??[])==0 || $this->note==null)
        return null;
        return json_encode($this->note);



        $data=[];


        foreach ($this->note as $k=>$v){

            $data[]=[
                "__typename"=>"JsonType",
                "k"=>$k,
                "v"=>$v
            ];
        }
        // $dta["data"]=$data;
        return $data;

    }

    function orders() {

        return $this->hasMany(Order::class)->whereHas('paymentinfo',function($q){
            $q->where('state','!=',3);

        });
    }
}
