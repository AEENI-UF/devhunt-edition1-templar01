<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request;
use Twilio\Rest\Client;
 function sendSMS($numero)
    {

        $sid    = "ACfa7c7985e42b46859c48d15678eab5ea";
    $token  = "fcfa5b1306c24643d5b2e83e90121c32";
    $twilio = new Client($sid, $token);
    $rand = rand(100000, 999999);
    $message = $twilio->messages
                  ->create($numero, // to
                           array(
                               "messagingServiceSid" => "MG253fd592432509da0a1919ab3292265a",
                               "body" => $rand
                           )
                  );

        return $message->body;

    }
