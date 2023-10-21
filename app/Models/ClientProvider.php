<?php

namespace App\Models;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            $qq->where('state','=',2)->orWhere('state','!=',2);
        });
        return $this->pays_excutes()->rassed_acetvities();
    }
    public function pay_sum()
    {
        # code...
        return $this->rassed_acetvities()->sum('amount');
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
