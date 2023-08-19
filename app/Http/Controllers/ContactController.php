<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //


    function generateRandomPlayerId() {
        // Generate a random 10-digit number
        $playerId =5245499203;
        // 51422956208     //mt_rand(1000000000, 88888888886);
        return $playerId;
    }

    public function index()
    {


        $apiKey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiJmOGViMzdhMC04ZjkxLTAxM2ItYzcyZi0wOWZlOTFiMjk0MWIiLCJpc3MiOiJnYW1lbG9ja2VyIiwiaWF0IjoxNjc2NDg4MDczLCJwdWIiOiJibHVlaG9sZSIsInRpdGxlIjoicHViZyIsImFwcCI6ImNoZWNrdXNlcl9ieV9pIn0.7BMOzaCo8NP0iXa8Ob9RpFIeYW3E7mhzXbo098s0n2M';

// Replace 'YOUR_PLAYER_ID' with the ID of the player you want to search for

// Generate a random player ID
$randomPlayerId = $this->generateRandomPlayerId();

// API endpoint URL for searching a player by ID
$url = "https://api.pubg.com/shards/steam/players/$randomPlayerId";

// Create a new cURL resource
$curl = curl_init();

// Set the required HTTP headers
$headers = [
    'Authorization: Bearer ' . $apiKey,
    'Accept: application/vnd.api+json'
];

// Set the cURL options
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers
]);

// Execute the request and get the response
$response = curl_exec($curl);

// Check for cURL errors
if (curl_errno($curl)) {
    $error = curl_error($curl);
    // Handle the error as needed
}

// Close the cURL resource
curl_close($curl);

// Decode the JSON response
$data = json_decode($response, true);

// Access the player data

//return dd($data);
if (isset($data['data'])) {
    $playerData = $data['data'];
    // Process and display the player data as needed

    // Get the platform
    $platform = $playerData['attributes']['shardId'];
    if ($platform === 'steam') {
        $platformName = 'PC (Steam)';
    } elseif ($platform === 'kakao') {
        $platformName = 'Kakao';
    } elseif ($platform === 'psn') {
        $platformName = 'PlayStation';
    } elseif ($platform === 'xbox') {
        $platformName = 'Xbox';
    } elseif ($platform === 'stadia') {
        $platformName = 'Stadia';
    } else {
        $platformName = 'Unknown';
    }

    echo "Player Platform: $platformName";
} else {
    // Handle the case when the player data is not found
}

        return view('admin.contact.index');
        # code...
    }


    public function replay(Contact $contact)
    {


    //    return dd($orders);
        # code...

        return view('admin.contact.replay',['contact'=>$contact]);
    }

    public function update(Request $request,Contact $contact)
    {
        $this->validate($request,[
            'replay'=>'required|string'
        ]);
        $contact->reply=$request['replay'];

        $contact->save();

        return redirect()->route('admin.contacts')->with('status','تم الرد بنجاح ');
        # code...
    }



    public function sendmeassge(Request  $request){

        if($request->isMethod('post')){
        $request->validate([

            'name'=>['required'],
            'email'=>['required','max:191'],
            'message'=>['required'],
            'subject'=>['required']
        ]);

        }
       $contact=Contact::create([
           'name'=>$request['name'],
           'email'=>$request['email'],
           'message'=>$request['message'],
           'phone'=>$request['phone'],
           'subject'=>$request['subject']
       ]);

//        $contact->save();



       return redirect()->back()->with('stat','ok')->with('status','تم ارسال الرسالة بنجاح ');


    }
}
