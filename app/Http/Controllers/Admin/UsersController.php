<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadeController;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Mail\RestorAccountMail;
use App\Models\Order;
use App\Models\User;
use App\Models\UserNotification;
use App\Notifications\CustomPasswordCodeNotification;
use App\Notifications\RestorAccountNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {




        // $onesignalAppId = '387916b2-306e-4d0b-bd19-cc8a4cbc08cf'; // Replace with your OneSignal App ID
        // $onesignalRestApiKey = 'MDdkZjYxMDgtMmJlNi00MzJmLTgwMjktYzllOGVhNjhlYTU3'; // Replace with your OneSignal REST API Key

        // $notificationData = [
        //     'contents' => [
        //         'en' => 'You have a new message!', // Customize the notification message here
        //     ],
        //     // 'include_player_ids' => [
        //     //     'player_id_1', // Replace 'player_id_1', 'player_id_2', etc. with the actual player IDs of the users you want to target
        //     //     'player_id_2',
        //     //     'player_id_3',
        //     //     'player_id_4',
        //     // ],
        //     'included_segments' => ['All'], // Send to all subscribers
        // ];

        // $response = Http::withHeaders([
        //     'Authorization' => 'Basic ' . base64_encode($onesignalRestApiKey . ':'),
        //     'Content-Type' => 'application/json',
        // ])->post('https://onesignal.com/api/v1/notifications', $notificationData);

        // if ($response->successful()) {
        //     // Successfully sent the notification
        //     // You can access the response data using $response->json()
        // } else {
        //     // Failed to send the notification
        //     // You can access the response data using $response->json()
        // }

        // return dd($response);


        // echo phpinfo();

        // echo '<br/>';
        // echo '<br/>';
        // echo '<br/>------------';
        // echo '<br/>';
        // return 'hi';

        //         $userNotification=UserNotification::orderBy('id','desc')->first();


        // $url = 'https://fcm.googleapis.com/fcm/send';

        // $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        //  'id' => $userNotification->id,
        //  "data"=>$userNotification->data,
        //  'status'=>"done",
        // 'created_at'=>date('Y/m/d H:i:s')
        // );
        // $notification = array(
        // 'title' =>$userNotification->title,
        // 'body' => $userNotification->body,
        // 'image'=> $userNotification->img??'',
        // 'sound' => 'default',
        // 'badge' => '1',);
        // $arrayToSend = array(
        // 'registration_ids' => ['eh26hRwURgGz1k4YogpspB:APA91bE5gZmqglFelCeXQdyxqqICE1vQEqAfPMdMJM7SFlWGhXkWhrYnFH9or08dwbUxxJy-mlt9Lx9nBHWsAcv6QxlfDvKkaogy6xtXfIyRFC-kLXN6le2zv6wONtCT32-uX3rRHfvC'],
        // 'notification' => $notification,
        // 'data' => $dataArr,
        // 'priority'=>'high');

        // $fields = json_encode ($arrayToSend);
        // $headers = array (
        //     'Authorization: key=' . config('firebase.server_key'),
        //     'Content-Type: application/json'
        // );

        // $ch = curl_init ();
        // curl_setopt ( $ch, CURLOPT_URL, $url );
        // curl_setopt ( $ch, CURLOPT_POST, true );
        // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        // curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        // curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        // $result =
        //  curl_exec ( $ch );

        // return var_dump($result);
        // curl_close ( $ch );

        //  $notificationData = [
        //     'title' => $userNotification->title,
        //     'body' => $userNotification->body,
        //     'data'=>[
        //         'data'=>$userNotification->data,
        //         'created_at'=>date('Y/m/d H:i:s'),
        //         "id"=>$userNotification->id
        //     ]
        // ];

        // // Get the FCM registration tokens of your users
        // $registrationTokens =$userNotification->user->f_token->pluck('token')->toArray();

        // // [
        // //     'token_user_1',
        // //     'token_user_2',
        // //     // Add more tokens here for other users
        // // ];

        // // Prepare the HTTP request data
        // $data = [
        //     'message' => [
        //         'notification' => $notificationData,
        //         'token' => $registrationTokens,
        //     ],
        // ];

        // // Send the HTTP POST request to the FCM API
        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer '.config('firebase.server_key'),
        //     'Content-Type' => 'application/json',
        // ])->post('https://fcm.googleapis.com/v1/projects/noohcardgame/messages:send', $data);

        // // Handle the response or any errors if needed
        // if ($response->successful()) {

        //     // Successfully sent the notification
        //     // You can access the response data using $response->json()
        // } else {
        //     // Failed to send the notification
        //     // You can access the response data using $response->json()
        // }

        // return dd($response);


//         $userNotification=UserNotification::orderBy('id','desc')->first();

//         //POST


//         $ch = curl_init();

//         $message=[
//             "message"=>[
//                    "notification"=>[
//                     'title' =>$userNotification->title,
//         'body' => $userNotification->body,
//         'image'=> $userNotification->img??'',
//         'sound' => 'default',
//         'badge' => '1'
//                    ],
//                    "token"=>auth()->user()->f_token()->pluck('token')->first()
//             ]
//             ];
// curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/noohcardgame/messages:send');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($message));

// $headers = array();
// $headers[] = 'Authorization: Bearer '.config('firebase.server_key');
// $headers[] = 'Content-Type: application/json';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }

// return dd($result);
// curl_close($ch);





        if($request->has('change_language'))
        {app()->setLocale($request['change_language']);

        }
         if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        if(isset($request['ban'] )&& $request["ban"]==1)
        {
            $users=User::onlyBanned()->get();

        }
        else
        $users = User::with('roles')->get();

        return view('admin.users.index', compact('users'));
    }


    public function ban(User $user)
    {
        $roles = Role::get()->pluck('name', 'name');

        return view('admin.users.ban-user',compact('user','roles'));
        # code...
    }
    public function ban_store(Request $request,User $user)
    {


        if($request->has('type') && $request['type']=="unban")
        $user->unban();
        else
        $user->ban(["expired_at"=>$request['expired_at'],'comment'=>$request["comment"]]);



        UserNotification::create([
            'title'=>'عذرا لقد تم حظر حسابك',
            'body'=>$request['comment'],
            'data'=>[
                'type'=>'ban',
                'action'=>'log_out'
            ],
            'user_id'=>$user->id,
            "created_at" => date('Y/m/d H:i:s')

            ]);


        return redirect()->route('admin.users.index');
        return view('admin.users.ban-user',compact('user'));
        # code...
    }


    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');

        $permissions = Permission::get()->pluck('name', 'name');

        return view('admin.users.create', compact('roles','permissions'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }







        $this->validate($request,[
        'name' => 'required',
        'username' =>['min:4','regex:/^[a-z\d_.]{2,20}$/i','required','string', 'max:191', 'unique:users'],
        'phone' => ['string','min:9', 'max:9', 'unique:users'],
        'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
        'password' => ['required',
        Rules\Password::defaults()->
        mixedCase()->
        min(8)->
        letters()->
        numbers()->symbols()],
    ],[
        'username.regex'=>'ادخل اسم مستخدم صحيح',
        'username.unique'=>'اسم المستخدم مستخدم بالفعل',
        'email.unique'=>'عذرا هذا البريد مستخدم بالفعل',
        'password.mixedCase'=>'يجب ان تحتوي كلمة السر على حرف واحد على الاقل Aاو s',
        'password.*'=>' يجب ان تحتوي كلمة السر على حرف واحد على الاقل ورقم ورمز مثل ($%^&@)',
        'password.numbers'=>' يجب ان تحتوي كلمة السر على حرف واحد على الاقل ورقم ورمز مثل ($%^&@)',
        'password.symbols'=>' يجب ان تحتوي كلمة السر على حرف واحد على الاقل ورقم ورمز مثل ($%^&@)',
    ]);






        $user = User::create($request->all());
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);

        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');

        $permissions = Permission::get()->pluck('name', 'name');

        return view('admin.users.edit', compact('user', 'roles','permissions'));
    }

    /**
     * Update User in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {


        if (! Gate::allows('users_manage')) {
            return abort(401);
        }


        if($request['username'] != $user->username )
        $this->validate($request,[
            'username' =>['min:4','regex:/^[a-z\d_.]{2,20}$/i','required','string', 'max:191', 'unique:users'],
        ]);
        if($request['email'] != $user->email )
        $this->validate($request,[
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
        ]);

        if($request['password']!=null)
       $user->update([
        'name'=>$request['name'],
        'username'=>$request['username'],
        'email'=>$request['email'],
        'password'=>Hash::make($request['password'])
       ]);

       else
       $user->update([
        'name'=>$request['name'],
        'username'=>$request['username'],
        'email'=>$request['email'],
       ]);


       $roles = $request->input('roles') ? $request->input('roles') : [];
       $user->syncRoles($roles);
       $permissions = $request->input('permissions') ? $request->input('permissions') : [];
       $user->syncPermissions($permissions);
        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }



    //     $user->bussinses()->delete();
    //     $user->products()->delete();
    //     $user->services()->delete();

    //    // $upld= new UploadeController();
    //    // $upld->delete_file($user->avatar);
    //     $user->services()->delete();
    //     $user->orders()->delete();
    //     $user->chats()->delete();
               $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        User::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

}
