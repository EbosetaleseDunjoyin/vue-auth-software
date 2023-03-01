<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //Get Authenticated user
    public function userProfile(){
        
        $user = auth()->user();
        try{
            if(!$user){
                 return response()->json([
                    'status' => false,
                    'message' => 'unauthorized user',
                   
                ], 400);
            }

            $userProfile = User::where('id',$user->id)->with('user_profile')->first();

            return response()->json([
                'status' => true,
                'message' => 'user details gotten sucessfully',
                'data' => $userProfile
            ], 200);
        }catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
      
    }

        public function createIntrests(Request $request){
            try{
                
                $validateUser = Validator::make($request->all(), 
                [
                    'user_id' => 'required',
                    'intrests' => 'required',
                ]);

                if($validateUser->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors()
                    ], 422);
                }

                $userprofile = UserProfile::where('user_id', $request->user_id)
                ->update(['intrests' => $request->intrests]);

                if($userprofile){
                    return response()->json([
                        'status' => true,
                        'message' => "intrests updated ",
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
