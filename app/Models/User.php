<?php

namespace App\Models;

use App\Notifications\CustomRestPasswordNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements BannableContract
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, Bannable
    ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'phone',
        'gendar',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];





    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomRestPasswordNotification($token));
    }
    public function getEmailVerifiedAtAttribute($value)
    {

        if ($value == null)
            return false;
        else
            return true;
    }
    public function getPhoneVerifiedAtAttribute($value)
    {

        if ($value == null)
            return false;
        else
            return true;
    }

    // public function findForPassport($username) {
    //     return self::where('username', $username)->first(); // change column name whatever you use in credentials
    //  }
    // $user->orders()->
    public  function orders()
    {
        return $this->hasManyThrough(Order::class,Paymentinfo::class);
       //return $this->hasMany(Order::class);
    }


    public function rassed()
    {
        return $this->hasOne(Rassed::class);
    }

    function rassed_acetvities()
    {

        return $this->hasManyThrough(RassedActevity::class, Rassed::class);
    }

    public function rassedy()
    {
        return $this->rassed->actevities()->accepted()->sum('amount');
    }



    public function order_products()
    {
        return $this->belongsToMany(
            Product::class,
            Order::class
        )->distinct();
    }





    function paymentinfos(){
        return $this->hasMany(Paymentinfo::class);
    }

    public function acivites_groupByDate($page = 1)
    {


        $_GET["page"] = $page;
        \request()->request->set("page", $page);
        $acivites = $this->rassed->actevities()->orderBy('updated_at', 'desc')
            ->paginate(20);
        $total = $acivites->total();
        $hasMorePages = $acivites->hasMorePages();

        $acivites = $acivites->groupBy(
            function ($date) {
                return Carbon::parse($date->updated_at)->format('Y-m-d'); // grouping by months

            }
        );


        $oac = [];
        foreach ($acivites as $k => $v) {




           // $date=DateTime();

            $oac[] = [
                "date" => $k,
                "actevities" => $v
            ];
        }
        return [
            'paginatorInfo' => [
                'total' => $total ?? 0,
                'hasMorePages' => $hasMorePages ?? false
            ],
            'activites' => $oac

        ];

        return array_reverse($oac);
    }

    public function lastacivites_groupByDate($date = null)
    {

        if($date==null)
        $date=now();

        $acivites = $this->rassed->actevities()
        ->where('updated_at','>',$date)
        ->orWhereHas('paymentinfo',function($qu)use($date){
            $qu->where('updated_at','>',$date);
        })
        ->orderBy('updated_at', 'desc')
            ->get();

        $acivites = $acivites->groupBy(
            function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d'); // grouping by months

            }
        );


        $oac = [];
        foreach ($acivites as $k => $v) {
            $oac[] = [
                "date" => $k,
                "actevities" => $v
            ];
        }
        return [
            'activites' => $oac
        ];
    }

    public function user_notifications()
    {

        return $this->hasMany(UserNotification::class)->orderBy('id', 'desc');
        # code...
    }

    public function orders_gr($page = 1)
    {


        $_GET["page"] = $page;
        \request()->request->set("page", $page);

        $porders =  $this->paymentinfos()->has('orders')->with('orders')->orderBy('updated_at', 'desc')->paginate(20);


        return [
            'orders_gr' => $porders,
            'paginatorInfo' => [
                'total' => $porders->total(),
                'hasMorePages' => $porders->hasMorePages()
            ]
        ];

        $orders = $this->orders()->has('paymentinfo')->orderBy('id', 'desc')
            ->with('paymentinfo')->paginate(20);

        $total = $orders->total();
        $hasMorePages = $orders->hasMorePages();

        $orders = $orders->groupBy(
            function ($data) {
                return  $data->paymentinfo->first()->id;
            }
        );


        $order_gruopBy = [];

        foreach ($orders as $key => $value) {
            $order_gruopBy[] = [
                "id" => $key,
                "orders" => $value,
                "paymentinfo" => $value[0]["paymentinfo"][0]
                //Paymentinfo::where("id","=",$key)->first()
            ];
        }


        return [
            'orders_gr' => $order_gruopBy,
            'paginatorInfo' => [
                'total' => $total,
                'hasMorePages' => $hasMorePages
            ]
        ];

        return array_reverse($order_gruopBy);
    }

    function f_token()
    {
        return $this->hasMany(FirebaseToken::class);
    }
}
