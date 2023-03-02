<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentmethod extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'slag',
        'help_steps',
        'note',
        'account_id',
        'is_auto_check'
    ];

    protected $casts=[
'help_steps'=>'array'
    ];

    function paymentinfos(){
        return $this->hasMany(Paymentinfo::class);
    }

    function helping_steps(){
        return json_encode($this->help_steps);
    }




    /*/*
    @retuen bool
    */

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
