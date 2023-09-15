<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use Loggable;

    use HasFactory;
    public $fillable=[
        'product_id',
        'to_date',
        'p_dic'
    ];





    public function howLong()
    {

        $now=now();
        //$derf=
        $this->to_date;
        # code...
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
        # code...
    }
}
