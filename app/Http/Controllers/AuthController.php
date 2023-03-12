<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email'=>'required|email',
            'password'=>'required',
            'confirm_password'=>'required|same:password'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>"Please check your input",
                "errors" => $validator->errors()
            ],400);
        }

        $payload = $request->all();
        $payload['password'] = bcrypt($payload['password']);
        $user = User::create($payload);

        $result['token'] = $user->createToken('auth_token')->plainTextToken;
        $result['name'] = $user->name;
        $result['email'] = $user->email;

        return response()->json([
            'status'=>200,
            'message'=>'Success Register User',
            'result'=>$result
        ]);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return response()->json([
                'status'=>401,
                'message'=>'Login failed, please check your email and password!!',
                'result'=>[]
            ]);
        }

        $auth = Auth::user();
        $result = (object)array(
            'token'=> $auth->createToken('auth_token')->plainTextToken,
            'name' => $auth->name,
            'email'=> $auth->email,
        );
        return response()->json([
            'status'=> 200,
            'message'=> 'Login Success',
            'result'=> $result
        ]);
    }
}
