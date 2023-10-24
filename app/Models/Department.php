<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
class Department extends Model
{
    use HasFactory;
    use Loggable;


    protected $fillable=[
        'name','note','type',
        'img',
        'reqs',
        'order_num',
        'active'
    ];
    protected $casts =[
        'reqs'=>'array',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
        # code...
    }




    function reqsQL() {






            $r=[];
            foreach($this->reqs??[] as $req){

                $r[]=[
                    'lable'=>$req['lable'],
                    "isreq"=>$req['isreq']!=false ? true: false
                ];

            }


            return $r;

    }

}
