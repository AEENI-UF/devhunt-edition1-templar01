<?php 
 
// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
require_once './vendor/autoload.php'; 
 
use Twilio\Rest\Client; 
 
$sid    = "AC33e9019810f856c080e4e3d6e8333c28"; 
$token  = "559bde2a768c4a7388ec38f5e744c797"; 
$twilio = new Client($sid, $token); 
 
$message = $twilio->messages 
                  ->create("+261326765209", // to 
                           array(  
                               "messagingServiceSid" => "MG8d12fa41ccdb1beae976189c965dfba3",      
                               "body" => "lelenty" 
                           ) 
                  ); 
 echo"Saltu";
print($message->sid);