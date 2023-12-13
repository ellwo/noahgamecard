<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Livewire\Component;
use Livewire\WithPagination;

class ReportTable extends Component
{

    public $dept_id="no";
    public $dateorder="no";
    public $search="";
    public $showform=0;
    public $deleteDept="no";
    public $paginate_num=20;
    public $fromDate=null;
    public $toDate=null;
    public $report='report';
    use WithPagination;
    protected $queryString=['report'];

    public function render()
    {



        if ($this->fromDate == null && $this->toDate==null) {
            $this->fromDate = date('Y-m-d H:i:s', strtotime(User::first()?->created_at));
            $this->toDate = date('Y-m-d H:i:s');
        }

        // else if($this->toDate==null){
        //     $this->fromDate = date('Y-m-d H:i:s',
        //     strtotime($this->fromDate));
        //     $date=new DateTime($this->fromDate);
        //     $this->toDate=$date->modify('+24 hours');
        //     $this->toDate=date('Y-m-d H:i:s',strtotime($this->toDate->format('Y-m-d H:i:s')));
        // }

        // else {
        //     $this->fromDate = date('Y-m-d H:i:s', strtotime($this->fromDate));
        //     //  strtotime($this->fromDate??$user->created_at);
        //     $this->toDate = date('Y-m-d H:i:s', strtotime($this->toDate));
        //     $d=new Carbon(strtotime($this->toDate),"Asia/Aden");

        //     $days=now()->diffInDays($d);
        //     if($days==0)
        //     {
        //         $this->toDate=now();
        //     }
        //     else{

        //         $date=new DateTime($this->toDate);
        //         $this->toDate=$date->modify('+24 hours');
        //         $this->toDate=date('Y-m-d H:i:s',strtotime($this->toDate->format('Y-m-d H:i:s')));
        //     }
        // }


        $departments=Order::whereHas('paymentinfo',function($pay){
            return $pay->where('state','>',0)
            ->where('state','<',3)
            ->whereBetween('created_at', [$this->fromDate, $this->toDate]);
        })->
        withSum(['paymentinfo:total_price'])->get()->groupBy(function($data){
            return $data->department->name;
        });


    //    return dd($this->toDate);
        foreach($departments as $k=>$v){
            $ordersSum[]=[
                'name'=>$k,
                'total_price'=>$v->sum('paymentinfo_total_price_sum'),
                'count'=>count($v)
            ];
        }

        // return dd($ordersSum);


        return view('admin.department.report-table',['departments'=>$ordersSum??[]]);
    }
}
