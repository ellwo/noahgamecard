<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;

class Paymentmethod extends Model
{
    use HasFactory,LaravelSubQueryTrait;

    protected $fillable=[
        'name',
        'slag',
        'help_steps',
        'note',
        'account_id',
        'is_auto_check',
    ];

    protected $casts=[
'help_steps'=>'array'
    ];

    function paymentinfos(){
        return $this->hasMany(Paymentinfo::class);
    }
    function rassed_actevities(){
        return $this->hasManyThrough(RassedActevity::class,Paymentinfo::class);
    }


    function helping_steps(){
        return json_encode($this->help_steps);
    }




    /*/*
    @retuen bool
    */
//active
public function scopeActive($q)
{
    return $q->where('id','!=',5);
    # code...
}
    function check_code($code){

        if(strlen($code)>8){

        }

        $check_state=false;
        switch($this->id){

            case 1 :

                break;



        }





        return $check_state;
    }



}
