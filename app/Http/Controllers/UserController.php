<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        return User::updateorcreate(['id' => $request->id], [
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
    }

    public function list()
    {
        return response()->json(User::select('id', 'name', 'username')->get());
    }

    public function destroy(User $user)
    {
        return $user->delete();
    }

    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function updateProfile(Request $request,User $user){
        // return Hash::make($request->update_password);
        if (Hash::check($request->update_password,$user->password)) {
            $user->name=$request->update_name;
            $user->username=$request->update_username;
          return  $user->save();
        } else {
            return response()->json([
                'msg'=>'Invalid Credentials'
            ]);
        }
        
    }

    public function changePassword(Request $request){
        $user=User::find(auth()->user()->id);
        if (Hash::check($request->current_password,$user->password)) {
            $user->password=Hash::make($request->change_new_password);
            return $user->save();
        } else {
            return response()->json([
                'msg'=>'Invalid Credentials'
            ]);
        }
        
    }
}
