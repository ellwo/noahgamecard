<?php

namespace App\Models;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentinfoExecuteBy extends Model
{
    use HasFactory,LaravelSubQueryTrait;

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

    public function rassed_actevity()
    {

        return $this->paymentinfo->rassed_actevity();
        # code...
    }

}
