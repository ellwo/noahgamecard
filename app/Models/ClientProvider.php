<?php

namespace App\Models;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ClientProvider extends Model
{
    use HasFactory,LaravelSubQueryTrait;
    protected $fillable=[
        'name',
        'phone',
        'email',
        'rassed',
        'active',
        'beas_url',
        'info'
    ];



    public function pays_excutes()
    {
        return $this->morphMany(PaymentinfoExecuteBy::class, 'execute');
    }

    public function rassed_acetvities(){

        //return $this->hasManyThrough(Paymentinfo::class,$this->pays_excutes());
        //return $this->hasManyThrough();
        return RassedActevity::whereHas('paymentinfo',function($q){
            $q->whereIn('id',$this->pays_excutes()->pluck('paymentinfo_id')->toArray());
        })->whereHas('paymentinfo',function($qq){
            $qq->where('state','=',2);
        });
        return $this->pays_excutes()->rassed_acetvities();
    }

    public function paymentinfos()
    {
        return Paymentinfo::whereIn('id',$this->pays_excutes()->pluck('paymentinfo_id')->toArray());

        return $this->hasManyThrough(Paymentinfo::class,PaymentinfoExecuteBy::class);
        # code...
    }
    public function pay_sum_orgin()
    {


        // return $this->rassed_acetvities()->get()->first();
        $sum=0.0;
        foreach ($this->rassed_acetvities()->get() as $r) {
            $sum+=$r->paymentinfo->order->product
            ->provider_products()->where('client_provider_id','=',$this->id)->first()->price;
        }

        return $sum;
        return $this->rassed_acetvities()->sum('amount');
    }
    public function pay_sum()
    {

        # code..
        return $this->rassed_acetvities()->sum('amount');
    }


    function rassedy() {


   $userid = 17577;
   $mobile = "778928008";
   $url = 'https://toponline.yemoney.net/api/yr/info';
   
   $userid=$this->api_userid;
   $mobile=$this->api_phone;
   $password=$this->api_password;
   $api_rassedurl=$this->api_rassedurl;
   $username=$this->api_username;
   
   
   $transid="2303";
     $paras = [
         'transid' => $transid,
         'token' => $this->genurateToken($transid),
         'userid' => $userid,
         'mobile' => $mobile,
         'action' => 'balance'
     ];
    //  Cache::forget('rassed');
     $res =Cache::remember('rassed',60*60,function()use($url,$paras){
       //return
       $respone= Http::get($this->api_rassedurl, $paras);
       return $respone->json('balance');
     });
     return $res;

    }

    function genurateToken($transid)
    {

   $username = "778928008";
   $password = "Asd777777777";
   $pay_url='https://toponline.yemoney.net/api/yr/gameswcards';
   $chack_url='https://toponline.yemoney.net/api/yr/info';
   $mobile = "778928008";
   $mobile=$this->api_phone;
   $password=$this->api_password;
   
   $username=$this->api_username;
  
        $hashPassword = md5($password);
        $token = md5($hashPassword . $transid . $username . $mobile);
        return $token;
    }

    public function scopeActive($query)
    {
        return $this->where('active','=',1);
        # code...
    }
    public function active_departments()
    {
        return $this->belongsToMany(Department::class,'provider_department')
        ->wherePivot('active','=',1);
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class,'provider_department')
        ->withPivot('active');
    }
    public function provider_products()
    {
        return $this->hasMany(ProviderProduct::class);
    }
    public function products()
    {
        return $this->hasManyThrough(Product::class, ProviderProduct::class);
    }
}
