<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserProfileRequest;
use App\Models\Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function login(Request $request)
    {
        $email = $request->post('email');
        $password = $request->post('password');
        if (!Auth::guest()) {
            return redirect('/dashboard');
        }
        if (strlen($email) && strlen($password)) {
            if (Auth::attempt(['email' => $email, 'password' => $password],true)) {

                return redirect('/dashboard');
            }
        } else {
            return view('user/login');
        }
    }

    function uploadProfile(UserProfileRequest $request)
    {
        $id = Auth::id();
        $currentUserModel = User::find($id);
        $file = $request->file('file');
        $uploaded_file = (new Files())->upload($file, User::class, $id);
        $currentUserModel->profile_file_id = $uploaded_file->id;
        $currentUserModel->save();
        return true;
    }

    function dashboard(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }
        return view('user/dashboard');
    }

    function profile(Request $request)
    {
        if ($request->post()) {
            $name = $request->post('name');
            $password = $request->post('password');
            $file = $request->file('file');
            $id = Auth::id();
            $currentUserModel = User::find($id);
            if(strlen($password))
                $currentUserModel->name = $name;
            if($file) {
                $uploaded_file = (new Files())->upload($file, User::class, $id);
                $currentUserModel->profile_file_id = $uploaded_file->id;
            }
            if(strlen(trim($password))) {
                $currentUserModel->password = Hash::make($password);
            }
            $currentUserModel->save();
            return redirect('/profile');
        }
        else
        {
            $model = User::find(Auth::id());
            $file = Files::find($model->profile_file_id);
            return view('user/profile',[
                'model'=>$model,
                'file'=>$file,
            ]);
        }
    }

    function logout(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }
        Auth::logout();
        return redirect('/login');
    }
}
