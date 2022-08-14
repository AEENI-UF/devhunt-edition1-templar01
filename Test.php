<?php
require_once './vendor/autoload.php';


use Illuminate\Http\Request;
use Twilio\Rest\Client;
// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md


class Test{

    public function sendSMS()
    {
    $sid    = "ACfa7c7985e42b46859c48d15678eab5ea";
    $token  = "fcfa5b1306c24643d5b2e83e90121c32";
    $twilio = new Client($sid, $token);
    $rand = rand(100000, 999999);
    $message = $twilio->messages
                  ->create("+261328720691", // to
                           array(
                               "messagingServiceSid" => "MG253fd592432509da0a1919ab3292265a",
                               "body" => $rand
                           )
                  );

        print($message->body);

    }


}
