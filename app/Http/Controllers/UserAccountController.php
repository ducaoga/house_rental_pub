<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserAccountController extends Controller
{
    /**
     * Display  resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //check if current user is super admin ...
            if(auth()->user()->user_role === 99) {
                //get all data ...
                $data = User::select('*')->where('is_active', 0)->where('user_role', 1)->get();
                return response()->json(['data' => $data], 200);

            } else {
                return response()->json(['message' => 'Welcome to Gail House Rental! I hope you enjoy the app. :)'], 200);
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            //query error ...
            return response()->json($ex, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json(['data' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        try {
            //check if current user is super admin ...
            if(auth()->user()->user_role === 99) {
                //update status to active
                $user->where('user_role', 1)->where('id', $user->id)->update(['is_active' => 1]);
                return response()->json(['message' => 'Successfully activated.'], 200);

            } else {
                return response()->json(['message' => 'Welcome to Gail House Rental! I hope you enjoy the app. :)'], 200);
            }
        } catch(\Illuminate\Database\QueryException $ex) { 
            //query error ...
            return response()->json($ex, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            //check if current user is super admin ...
            if(auth()->user()->user_role === 99) {
                //update status to inactive
                $user->where('user_role', 1)->where('id', $user->id)->update(['is_active' => 0]);
                return response()->json(['message' => 'Successfully deactivated.'], 200);

            } else {
                return response()->json(['message' => 'Welcome to Gail House Rental! I hope you enjoy the app. :)'], 200);
            }

        } catch(\Illuminate\Database\QueryException $ex) { 
            //query error ...
            return response()->json($ex, 500);
        }
    }
}