<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        "accepted",
        "orginal_total",
        'note',
        "user_id",
        'coin_id'
    ];



    function coin() {

        return $this->belongsTo(Coin::class);
    }
    function orders(){

   // return $this->hasMany(Order::class);
        return $this->belongsToMany(Order::class,'order_paymentinfo');
    }

    public function paymentmethod(){
        return $this->belongsTo(Paymentmethod::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    function rassed_actevity() {
        return $this->hasOne(RassedActevity::class);
    }

    public function orginal_totalll(){

        $total=0.0;
        foreach($this->orders as $or){
            $total+=($or->product->price*$or->qun);
        }

        if($total!=0)
        return $total;
        else
        return $this->total_price;


    }

    public function getUpdatedAtAttribute($value){

        if(request()->path()=="graphql"){
        return $value;
        }


        $d=new Carbon($value,"Asia/Aden");


        $days=now()->diffInDays($d);


        $day=$d->format('Y-M-d H:i:s');

        // switch($days){
        //     case 0 : $day="اليوم منذ ";
        //     $hours=now()->diffInHours($d);
        //     $day.=$hours."ساعة";
        //     break;

        //     case 1 : $day="الامس";

        //     $day=$d->format(' h:i A  ').$day;

        //     break;
        //     case 2 : $day="منذ يومين";

        //     $day=$d->format(' h:i A  ').$day;

        //     break;
        //     case 7 :$day="منذ اسبوع";

        //     $day=$d->format(' h:i A  ').$day;
        //     break;
        //     case 10 :$day="منذ عشرة ايام ";

        //     $day=$d->format(' h:i A  ').$day;
        //     break;
        //     case 15 :$day="منذ نصف شهر";

        // $day=$d->format(' h:i A  ').$day;

        //     break;
        // }

        return $day;

      }
    public function getCreatedAtAttribute($value){


        if(request()->path()=="graphql"){
            return $value;
            }
        $d=new Carbon($value,"Asia/Aden");

        $days=now()->diffInDays($d);

        $day=$d->format('Y-M-d H:i:s');

     //   switch($days){
            // case 0 : $day="اليوم منذ ";
            // $hours=now()->diffInHours($d);
            // $day.=$hours."ساعة";
            // break;

            // case 1 : $day="الامس";

            // $day=$d->format(' h:i A  ').$day;

            // break;
            // case 2 : $day="منذ يومين";

            // $day=$d->format(' h:i A  ').$day;

            // break;
            // case 7 :$day="منذ اسبوع";

            // $day=$d->format(' h:i A  ').$day;
            // break;
            // case 10 :$day="منذ عشرة ايام ";

            // $day=$d->format(' h:i A  ').$day;
            // break;
            // case 15 :$day="منذ نصف شهر";

//        }
//        $day=$d->format(' h:i A  ').$day;

        return $day."  path/".request()->getBasePath();


    }
}
