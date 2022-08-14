<?php 
 
// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
require_once 'C:/Users/Menendezy/Documents/Portail/back/vendor/autoload.php';
 
use Twilio\Rest\Client; 
 
class SMSSend
{
    
    public function sendSMS($tel)
    {
        $sid    = "AC33e9019810f856c080e4e3d6e8333c28"; 
        $token  = "559bde2a768c4a7388ec38f5e744c797"; 
        $twilio = new Client($sid, $token); 
        $random = rand(100000, 999999);
        $message = $twilio->messages->create($tel, // to 
                           array(  
                               "messagingServiceSid" => "MG8d12fa41ccdb1beae976189c965dfba3",      
                               "body" => $random 
                           ) 
                  ); 
        return $message->body;
    }
}

