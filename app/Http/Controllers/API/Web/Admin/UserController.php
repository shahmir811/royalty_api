<?php

namespace App\Http\Controllers\API\Web\Admin;

use App\Models\{User};
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\{AddUserFormRequest, UpdateUserFormRequest};

class UserController extends Controller
{
    public function users()
    {
        $users = User::withTrashed()->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all system Users',
            'data' => [
                'users' => UserResource::collection($users)
            ]
        ], 200);
    }

    /////////////////////////////////////////////////////////////////////////
    public function AddUser(AddUserFormRequest $request) 
    {
        $newUser = new User;
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->role_id = $request->role_id;
        $newUser->password = bcrypt($request->password);
        $newUser->save();

        return response() -> json([
            'status' => 1,
            'message' => 'New user added successfully',
            'data' => [
                'user' => new UserResource($newUser)
            ]            
        ], 201);
    } 

    /////////////////////////////////////////////////////////////////////////
    public function updateUser($id, UpdateUserFormRequest $request)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->name    = $request->name;
        $user->role_id = $request->role_id;
        if($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();        

        return response() -> json([
            'status' => 1,
            'message' => 'User details updated successfully'
        ], 200);
    }

    /////////////////////////////////////////////////////////////////////////    
    public function updatePassword($id, Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|min:6',
        ]);
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return response() -> json([
            'status' => 1,
            'message' => 'User password updated successfully'
        ], 200);        
    }  
    
    /////////////////////////////////////////////////////////////////////////  
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
                
        return response() -> json([
            'status' => 1,
            'message' => 'User deleted successfully'
        ], 200);    
    }    

    /////////////////////////////////////////////////////////////////////////  
    public function changeUserStatus($id)
    {
        // $user = User::findOrFail($id);
        $user = User::withTrashed()->where('id', '=', $id)->first();
        if($user->deleted_at) {
            $user->restore();
        } else {
            $user->delete();
        }

        return response() -> json([
            'status' => 1,
            'message' => 'User status has been changed'
        ], 200);    

    }    

}
