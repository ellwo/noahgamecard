<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirebaseToken extends Model
{
    use HasFactory;
    protected $fillable=[
        'token','user_id',
        'device_id','device_name','device_ip'
    ];


    function user() {

        return $this->belongsTo(User::class);
    }
}
