<?php

namespace App\Http\Controllers;

use App\Models\FCMNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FCMNotificationController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'token' => 'required',
            //'user_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return response()->json($validator->errors()->toArray(), 422);

        FCMNotification::create([
            'user_id' => null,
            'token' => $request['token'],
        ]);

        return response()->json(['message' => 'success', 'status' => '200',], 200);
    }

    public function sendNotification()
    {
        $firebaseToken = FCMNotification::whereNotNull('token')->pluck('token')->all();

        //dd($firebaseToken);

        $SERVER_API_KEY = env('SERVER_API_KEY');

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'Title Notification '.rand(00000, 99999),
                "body" => 'Notification body '.rand(00000, 99999),
                "content_available" => true,
                "priority" => "high",
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        return response()->json(['message' => 'success '.$response, 'status' => '200',], 200);
    }
}
