<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

                                
        return view('admin.user_notifiy.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.user_notifiy.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request,[
            'title'=>['required'],
            'body'=>['required'],
        ]);

        if(!$request['to_all'])
        {
             $userNotification=UserNotification::create([
            'title'=>$request['title'],
            'body'=>$request['body'],
            'user_id'=>$request['user_id'],
            'img'=>$request['img']
        ]);

            return redirect()->route('usernotification')->with('status','تم ارسال الاشعار بنجاح');
        }
        else
        {
            $users= User::has('f_token')->get();
            foreach ($users as $user) {
                $userNotification=UserNotification::create([
                    'title'=>$request['title'],
                    'body'=>$request['body'],
                    'user_id'=>$user->id,
                    'img'=>$request['img']
                ]); # code...
            }

        return redirect()->route('usernotification')->with('status','تم ارسال الاشعار بنجاح');

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function show(UserNotification $userNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(UserNotification $userNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserNotification $userNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserNotification $userNotification)
    {
        //
    }
}
