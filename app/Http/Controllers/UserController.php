<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
class UserController extends Controller
{
    public function register(Request $request){
        $validatedData = $request->validate([
            'username'=>'required|unique:users,username|string',
            'name' => 'string|required',
            'date_of_birth' => 'required|date',
            'password' => ['required',
                            Password::min(8)
                                ->letters()
                                ->mixedCase()
                                ->numbers()
                                ->symbols()],
            'photo' => 'required|mimes:jpeg,jpg,png'
        ]);
        
        //file upload:
        $image = $validatedData['photo'];
        $uploadPath = $this->uploadImage($image);
        if($uploadPath == false){
            return response()->json('File Upload failed',400);
        }else{
            $validatedData['photo']= $uploadPath;
        }

        $user = User::create($validatedData);
        if($user){
            $token = $user->createToken('user_access_token')->accessToken;
        }
        return response()->json(['new user'=>$user,
                                        'token'=>$token],201);
    }

    public function getUser($username){
        if(empty($username)){
            return response()->json('username is required',400);
        }
        $user = User::where('username',$username)->first();
        if(!$user){
            return response()->json('user not found',404);
        }
        return response()->json($user,200);
    }


    private function uploadImage($image){
        $name = $image->getClientOriginalName();
        if($image->move(public_path('images'),$name)){
            
            return 'images/'.$name;
        }
        return false;
    }
}
