<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Discount extends Model
{
    use HasFactory;

    protected $fillable=[
        'dis_persint','role_id',
        'note'
    ];


   public function role(){

    return $this->belongsTo(Role::class,'role_id');
    }

}
