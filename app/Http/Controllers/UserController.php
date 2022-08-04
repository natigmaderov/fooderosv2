<?php

namespace App\Http\Controllers;
use App\Models\PhoneVerfy;


use App\Models\SocialUsers;
use App\Models\User;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function register(Request $request){



        $request->validate([
           'name' =>'required',
            'phone'=>'required',

        ]);
        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'phone'=>'required',
        ]);

            $user =  User::create([
                'name'=>$request->input('name'),
                'phone'=>$request->input('phone'),
                'role_id'=>1,
                'status'=>0
            ]);
            $social = SocialUsers::where('email',$request->email)->first();
            $social->phone = $request->phone;
            $social->user_id = $user->id;
            $social->save();

            if ($token = JWTAuth::fromUser($user)){

                return response([
                    'token'=>$token,
                    'token_type'=>'bearer',
                    'expires_in'=>auth()->factory()->getTTL()*60
                ]);

            }
            else {
                return 'failed';
            }





    }

    public function get_user()
    {
        if(\auth()->user()){
            return response()->json(auth()->user());

        }

        return response([
            'Message'=>"Invalid token"
        ],500);
    }


      public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refreshToken(){

// Pass true as the first param to force the token to be blacklisted "forever".
// The second parameter will reset the claims for the new token
        $newToken = auth()->refresh();
        return response([
            'token'=>$newToken,
            'token_type'=>'bearer',
            'expires_in'=>auth()->factory()->getTTL()*60
        ]);



    }

    public function active(Request $request){
        $active = 0;
        if(\auth()->user()) {
            $active = 1;
            return response([
               "status"=>$active
            ],201);
        }
            return response([
                "status"=>$active
            ],201);



    }


}
