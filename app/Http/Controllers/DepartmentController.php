<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DepartmentController extends Controller
{
    //


    public function __construct()
{
    $this->middleware(['permission:ادارة الاقسام']);
}


    public function index(Request $request)
    {
        if(!isset($request['report']))
        return view('admin.department.show');
    else
    return view('admin.department.report');
        # code...
    }


    public function create()
    {
        return view('admin.department.create');
        # code...
    }

    public function store(Request $request){







        $reqs=[];







        if($request->isMethod('POST')){


            $this->validate($request,[
                'name'=>'required',
                'imgurl'=>'required',
                'order_num'=>['required','unique:departments,order_num']
            ]);



        if(isset($request["reqname"])){

            $i=0;
            foreach($request["reqname"]??[] as $name){
                $reqs[]=[
                    "lable"=>$name,
                    "type"=>"text",
                    "isreq"=>$request["reqisreq"][$i]??false
                ];
                                $i++;
            }

        }
                $dept=Department::create([
                   'name'=>$request['name'],
                    'note'=>$request['note'],
                    'img'=>$request['imgurl'],
                    "reqs"=>$reqs,
                    'order_num'=>$request['order_num']

                ]);

                Cache::flush();

                session()->flash('statt', 'ok');
                session()->flash('message', 'تم الحفظ بنجاح ');
               return redirect()->route('depts')->with('statt','ok');
                return $data = ['statt' => 'ok'];
            }





    }

    public function edit(Department $dept)
    {

        //$req=json_decode($dept->reqs);
      //  return dd($req[0]->lable);
        return view('admin.department.edit',['dept'=>$dept]);
        # code...
    }

    public function update(Request $request,Department $dept){




              if($request['order_num']!= $dept->order_num)
            $this->validate($request,[
                'name'=>'required',
                'imgurl'=>'required',
                'order_num'=>['required','unique:departments,order_num']

            ]);
            else
            $this->validate($request,[
                'name'=>'required',
                'imgurl'=>'required',
                'order_num'=>['required']
            ]);

            $reqs=[];
        if(isset($request["reqname"])){

            $i=0;
            foreach($request["reqname"]??[] as $name){
                $reqs[]=[
                    "lable"=>$name,
                    "type"=>"text",
                    "isreq"=>$request["reqisreq"][$i]??false
                ];
                                $i++;
            }

        }
                    $dept->update([
                        'name' => $request['name'],
                        'note' => $request['note'],
                        'img' => $request['imgurl'],
                        'reqs'=>$reqs,
                    'order_num'=>$request['order_num']
                    ]);
                    Cache::flush();
                    session()->flash('statt', 'ok');
                    session()->flash('message', 'تم التعديل بنجاح ');
                    return redirect()->route('depts');

            }







}
