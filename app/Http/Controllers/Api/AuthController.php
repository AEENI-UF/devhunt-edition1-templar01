<?php
namespace App\Http\Controllers\Api;
// require_once '/app/Http/Controllers/Api/authsms.php';
    require_once 'C:/Users/Menendezy/Documents/Portail/back/vendor/autoload.php';

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use App\Http\Controller\Api\SMSSend;
use Laravel\Sanctum\TransientToken;

class AuthController extends Controller
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
    


     /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {

        

        try {

            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'matricule'=>'required|exists:etudiants,matricule|unique:users,matricule',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }$key = $this->sendSMS('+261326765209');
            $user = User::create([
                'matricule'=>$request->matricule,
                'numero'=>$request->numero,
                'name' => $request->name,
                'key' =>$key,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            
            
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'key' =>$key,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            $key = $this->sendSMS('+261326765209');
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            $num = '+'.$user->numero;
            
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'key' =>$key,
                'num' =>$num,
                'email'=>$user->email,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function logoutUser(Request $request) 
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'You have been successfully logged out.'], 200);
        }
    
}
