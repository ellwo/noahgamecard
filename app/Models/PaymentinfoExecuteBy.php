<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentinfoExecuteBy extends Model
{
    use HasFactory;

    protected $fillable=[
        'paymentinfo_id',
        'execute_id',
        'execute_type',
        'state',
        'note',
        
    ];

    public function paymentinfo()
    {
        return $this->belongsTo(Paymentinfo::class);
    }

    public function execute()
    {
        return $this->morphTo();
    }
}
