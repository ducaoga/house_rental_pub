<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    
    public function register(Request $request) {
        // return $request->all();

        try {
            //get request data ...
            // $requestData = json_decode($request->all());
            $requestData = $request->all();
            $arrData = [
                'name' => isset($requestData['name']) ? $requestData['name'] : "",
                'email' => isset($requestData['email']) ? $requestData['email'] : "",
                'password' => isset($requestData['password']) ? $requestData['password'] : "",
                'confirmpassword' => isset($requestData['confirmpassword']) ? $requestData['confirmpassword'] : "",
            ];

            //validate ...
            $validator = Validator::make($arrData, [
                'name' => 'required|string',
                'email' => 'required|email|string',
                'password' => 'required|string',
                'confirmpassword' => 'required|same:password'
            ]);

            //validation ...
            if($validator->fails()){
                return response()->json($validator->errors(), 417);
            }

            //create user account
            $arrData['password'] = Hash::make($arrData['password']);
            $user = User::create($arrData);

            return response()->json(['message' => 'Successfully registered. Please wait for account activation.'], 200);

        } catch(\Illuminate\Database\QueryException $ex) { 
            //query error ...
            return response()->json($ex, 500);
        }

    }
    
    public function login(Request $request) {

        //get request data ...
        // $requestData = json_decode($request->getContent());
        $requestData = $request->all();
        $arrData = [
            'email' => isset($requestData['email']) ? $requestData['email'] : "",
            'password' => isset($requestData['password']) ? $requestData['password'] : "",
        ];

        //validate ...
        $validator = Validator::make($arrData, [
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);

        //validation ...
        if($validator->fails()){
            return response()->json($validator->errors(), 417);
        }

        //if invalid email and password ...
        if(!auth()->attempt(['email' => $arrData['email'], 'password' => $arrData['password']])){
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        //if email and password exists but deactivated ...
        if(auth()->attempt(['email' => $arrData['email'], 'password' => $arrData['password'], 'is_active' => 0])){
            return response()->json(['message' => 'Deactivated account.'], 401);
        }

        //return token ...
        $user = auth()->user();
        return response()->json(['token' => $user->createToken('AppToken')->accessToken], 200);

    }

}
