<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Discount extends Model
{
    use HasFactory;
    use Loggable;

    protected $fillable=[
        'dis_persint','role_id',
        'note',
        'department_id'
    ];



    public function department()
    {
        return $this->belongsTo(Department::class);
    }
   public function role(){

    return $this->belongsTo(Role::class,'role_id');
    }

}
