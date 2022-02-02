<?php

namespace App\Http\Controllers\API\Auth;

use Hash;
use Mail;
use App\Models\User;
use App\Mail\ForgotPassword;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function userForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::withTrashed()->where('email', '=', $request->email)->first();
        $verification_key = time();

        if(!$user) {
            return response() -> json([
                'status' => 0,
                'message' => 'No user found',
            ], 200);   
        } 


        $user->verification_key = $verification_key;
        $user->save();
        Mail::to($user->email)->send(new ForgotPassword($user));


        return response() -> json([
            'status' => 1,
            'message' => 'Email link sent',
        ], 200);   

    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'verification_key' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $user = User::where('slug', '=', $request->slug)->first();
        
        if($user->verification_key == $request->verification_key) {
            $user->verification_key = null;
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response() -> json([
                'status' => 1,
                'message' => 'User password changed successfully',
            ], 200);   
        
        } else {

            return response() -> json([
                'status' => 1,
                'errors' => [
                    'verification_key' => ['Verification key is incorrect']
                ]
            ], 422);               
        }


    }
}
