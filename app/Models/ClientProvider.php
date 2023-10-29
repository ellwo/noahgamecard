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
    public function pay_sum_orgin()
    {

        $sum=0.0;
        foreach ($this->rassed_acetvities() as $r) {
            $sum+=$r->paymentinfo->order->product->provider_products()->where('client_provider_id','=',$this->id)->first()->price;
        }

        return $sum;
        return $this->rassed_acetvities()->sum('amount');
    }
    public function pay_sum()
    {

        # code..
        return $this->rassed_acetvities()->sum('amount');
    }


    public $userid = 17577;
    public $mobile = "777777777";
    public $username = "777777777";
    public $password = "Asd777777777";
    public $pay_url='https://toponline.yemoney.net/api/yr/gameswcards';
    public $chack_url='https://toponline.yemoney.net/api/yr/info';

    function rassedy() {

     $url = 'https://toponline.yemoney.net/api/yr/info';
     $transid="2303";
     $paras = [
         'transid' => $transid,
         'token' => $this->genurateToken($transid),
         'userid' => $this->userid,
         'mobile' => $this->mobile,
         'action' => 'balance'
     ];
    //  Cache::forget('rassed');
     $res =Cache::remember('rassed',60*60,function()use($url,$paras){
       //return
       $respone= Http::get($url, $paras);
       return $respone->json('balance');
     });
     return $res;

    }

    function genurateToken($transid)
    {
        $hashPassword = md5($this->password);
        $token = md5($hashPassword . $transid . $this->username . $this->mobile);
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
