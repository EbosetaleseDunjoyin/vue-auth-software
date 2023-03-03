<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    // Register User
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                
                'email' => 'required|email|unique:users,email',
                'phone_no' => 'required|unique:users',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // Login User---------------------
    public function loginUser(Request $request)
    {
        try {
            $input = $request->all();
            $validateUser = Validator::make($request->all(), 
            [
                'email_phone' => 'required',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => $validateUser->errors()
                ], 422);
            }
             $fieldType = filter_var($request->email_phone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_no';
            $authenticate = auth()->attempt(array($fieldType => $input['email_phone'], 'password' => $input['password']));
        
            if(!$authenticate){
                return response()->json([
                    'status' => false,
                    'message' => 'Email or Password does not match with our record.',
                ], 422);
            }

            $user = User::with('user_profile')->where('email', $request->email_phone)->orWhere('phone_no' , $request->email_phone)
                ->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    //Logout User
    public function logoutUser(){
        // Get user who requested the logout
        $user = auth()->user();
        try{
             if(!$user){
                 return response()->json([
                    'status' => false,
                    'message' => 'unauthorized user',
                   
                ], 400);
            }
             $logout = Auth::user()->tokens()->delete();

            if($logout){
                return response()->json([
                    'status' => true,
                    'message' => 'logout succesfull',
                    
                ], 200);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }







    }

    //Send Verification mail ---------------------
    public function sendverification(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|exists:users,email',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }


            $user = User::where('email', $request->email)->first();

            // generate token here
            $token = $this->generateOtp($user->id);

            //Send mail for verification
            $event =  Mail::send('emails.emailVerification', ['token' => $token->otp], function($message) use($request){
                $message->to($request->email);
                $message->subject('Email Verification Mail');
            });

            if($event){
                return response()->json([
                    'status' => true,
                    'message' => 'Verification Link sent',
                ], 200);
            }
            else{
                 return response()->json([
                    'status' => false,
                    'message' => 'Verification Link not sent',
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    //Send Verification mail for password reset ---------------------
    public function forgotPassword(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|exists:users',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }


            $user = User::where('email', $request->email)->first();

            // generate token here
            $token = Str::random(8);
  
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);

            //Send mail for verification
            $event =  Mail::send('emails.passwordReset', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Password reset mail');
            });

            if($event){
                return response()->json([
                    'status' => true,
                    'message' => 'Verification Link sent',
                ], 200);
            }
            else{
                 return response()->json([
                    'status' => false,
                    'message' => 'Verification Link not sent',
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    //Send Otp SMS ---------------------
    public function sendOtp(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'phone_no' => 'required|exists:users',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'errors' => $validateUser->errors()
                ], 422);
            }


            $user = User::where('phone_no', $request->phone_no)->first();

            // generate token here
            $token = $this->generateOtp($user->id);

            //Send mail for verification
            $intTime = strtotime($token->expire_at);
            $time = Carbon::parse($token->expire_at)->diffForHumans();
           $event = $this->sendOtpSms($token->otp,$time,$request->phone_no);

            if($event){
                return response()->json([
                    'status' => true,
                    'message' => "otp sent ",
                    'data' => $user->id
                    
                ], 200);
            }
            else{
                 return response()->json([
                    'status' => false,
                    'errors' => 'otp not sent',
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    //Verify Sms OTP
    public function verifyOtp(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'user_id' => 'required',
                'otp' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'errors' => $validateUser->errors()
                ], 422);
            }


            $otpVerify = VerificationCode::where('user_id', $request->user_id)
            ->where('otp',$request->otp)->first();

            $userupdate = User::where('id', $request->user_id)->update(['status' => 'active']);
             $user = User::where('id', $request->user_id)->first();
            if($userupdate && $otpVerify){
                return response()->json([
                    'status' => true,
                    'message' => "acccount verified ",
                    'token'  => $user->createToken("API TOKEN")->plainTextToken
                    
                ], 200);
            }
            else{
                 return response()->json([
                    'status' => false,
                    'errors' => 'an issue arised with your otp',
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // Verify email otp
    public function verifyEmailOtp($otp)
    {
        try {

           
            $Veuser = VerificationCode::where('otp',$otp)->latest()->first();
              $now = Carbon::now();

            if(!$now->isBefore($Veuser->expire_at)){
                 return response()->json([
                    'status' => false,
                    'message' => "otp expired",
                    
                ], 400);
            }
           
            if(!$Veuser){
                return response()->json([
                    'status' => false,
                    'message' => "otp verification failed ",
                    
                ], 400);
            }
            $userUpdate = User::where('id', $Veuser->user_id)->update(['status' => 'active','email_verified_at' => Carbon::now()]);
            $user = User::where('id', $Veuser->user_id)->first();
            if($user && $userUpdate ){
                return response()->json([
                    'status' => true,
                    'message' => "acccount verified ",
                    'user_id' => $user->id,
                    'token'  => $user->createToken("API TOKEN")->plainTextToken
                    
                ], 200);
            }
           

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // Verify resetPassword Token
    public function verifyPasswordResetToken(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|exists:users',
                'token' => 'required',
                
            ]);

            $check = DB::table('password_reset_tokens')
             ->where(
                'email' , $request->email
                )
            ->where(
                'token' , $request->token
                )
                ->latest()->first();

            
                $user = User::where('email',$request->email)->first();
           
            if(!$check ){
                 return response()->json([
                    'status' => false,
                    'message' => "token does not exist",
                    
                ], 400);
            }
            return response()->json([
                'status' => true,
                'message' => "token exists ",
                
                
            ], 200);
            
           

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // ResetPassword 
    public function resetPassword(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|exists:users',
                'password' => 'required',
                
            ]);

            $check = User::where('email',$request->email)->update(['password' => Hash::make($request->password)]);

            

           
            if(!$check ){
                 return response()->json([
                    'status' => false,
                    'message' => "password reset failed",
                    
                ], 400);
            }
            return response()->json([
                'status' => true,
                'message' => "Password reset",
                
                
            ], 200);
            
           

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // Generate OTP----------------
     public function generateOtp($id)
    {
        $user = User::where('id', $id)->first();

        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }
        
        

        $otp = rand(12345, 99999);
        // $check = VerificationCode::where('otp', $otp)->first();

        // if($check){
        //     return $this->generateOtp($id);
        // }

        // Create a New OTP
        return VerificationCode::create([
            'user_id' => $id,
            'otp' => $otp ,
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    //Send SMS
    public function sendSMS($token, $time,$phone_no)
    {
        $src= '9136574356';
        $dst='23409161436952';
        $type=0;
        $dr=0;
        $username= 'eboseogbidi2';
        $password='JpXFWXngxz@tFj9';
        $message = "Mazer App <br> This is the otp {$token} <br> It expires in {$time}";
        $params = [
            'src' => $src,
            'dst' => $dst,
            'type' => $type,
            'dr' => $dr,
            'user' => $username,
            'password' => $password,
            'msg' => $message,
        ];

        $url = sprintf('http://smsc.txtnation.com:8091/sms/send_sms.php?%s', http_build_query($params));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
        // return file_get_contents($url) ;
        // if(!file_get_contents($url)) {return false;} 
    }
    //Send SMS via Sinch
    public function sendOtpSms($token, $time,$phone_no)
    {
        $service_plan_id = "12518211fa5d4c60979de306b128f50f";
        $bearer_token = "1c7cf75475ad43fc837f692ab2cda5cb";

        //Any phone number assigned to your API
        $send_from = "+447520651583";
        $phone_no = '+234'.substr($phone_no, 1);
        // $phone_no = '+234'.substr($phone_no, 1);
        //May be several, separate with a comma ,
        $recipient_phone_numbers = "recipient_phone_numbers"; 
        $message = "Mazer App This is the otp {$token} It expires in {$time}";

        // Check recipient_phone_numbers for multiple numbers and make it an array.
        if(stristr($phone_no, ',')){
        $phone_no = explode(',', $phone_no);
        }else{
        $phone_no = [$phone_no];
        }

        // Set necessary fields to be JSON encoded
        $content = [
        'to' => array_values($phone_no),
        'from' => $send_from,
        'body' => $message
        ];

        $data = json_encode($content);

        $ch = curl_init("https://us.sms.api.sinch.com/xms/v1/{$service_plan_id}/batches");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
        curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $bearer_token);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
         curl_close($ch);

        if(curl_errno($ch)) {
            return 'Curl error: ' . curl_error($ch);
        } else {
            return $result;
        }
       

        // return file_get_contents($url) ;
        // if(!file_get_contents($url)) {return false;} 
    }
   

    //update email
    public function updateEmail(Request $request){
        try{
            
            $validateUser = Validator::make($request->all(), 
            [
                'user_id' => 'required',
                'email' => 'required|unique:users',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $userprofile = User::where('id', $request->user_id)
            ->update(['email' => $request->email]);

            if($userprofile){
                 return response()->json([
                    'status' => true,
                    'message' => "email updated ",
                ], 200);
            }
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    //update password
    public function updatePassword(Request $request){
        try{
            
            $validateUser = Validator::make($request->all(), 
            [
                'user_id' => 'required',
                'password' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $userprofile = User::where('id', $request->user_id)
            ->update(['password' => Hash::make($request->password)]);

            if($userprofile){
                 return response()->json([
                    'status' => true,
                    'message' => "password updated ",
                ], 200);
            }
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }








}