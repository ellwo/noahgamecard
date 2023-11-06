<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderProduct extends Model
{
    use HasFactory;
    protected $fillable=[
        'product_id',
        'price',
        'name',
        'url',
        'client_provider_id',
        'active',
        'reqs','direct',
        'dispatch_at'
    ];
    protected $casts =[
        'reqs'=>'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

public function scopeActive($q)
{
    return $q->where('active','=',1);
    # code...
}
    public function client_provider()
    {
        return $this->belongsTo(ClientProvider::class);
    }
}

