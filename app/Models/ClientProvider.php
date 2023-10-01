<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProvider extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'phone',
        'email',
        'rassed',
        'active',
        'beas_url',
        'info'
    ];



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
