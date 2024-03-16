<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallApiCount extends Model
{
    use HasFactory;
    protected $fillable=[
        'paymentinfo_id',
        'info',
        'client_provider_id',
        'count'
        
    ];

    public function paymentinfo()
    {
        return $this->belongsTo(Paymentinfo::class);
    }

    function client_provider(){
        return $this->belongsTo(ClientProvider::class);
    }

}
