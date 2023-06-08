<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserProfileRequest;
use App\Models\Files;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function login(Request $request)
    {
        $email = $request->post('email');
        $password = $request->post('password');
        if (!Auth::guest()) {
            if (Auth::user()->isPatientUser()) {
                return redirect('/patient');
            } else {
                return redirect('/dashboard');
            }
        }
        if (strlen($email) && strlen($password)) {
            $u = User::where('email' , $email)->first();
            if($u && Hash::check($password, $u->password)) {
                if ($u->enable_2fa) {
                    session(['2fa_email' => $email]);
                    // generate code
                    $u->two_fa_code = rand(9999,99999);
                    $u->two_fa_time = time();
                    $u->save();
                    //send code by email
                    $mailData = [
                        'code' => $u->two_fa_code,
                    ];
                    Mail::to($email)->send(new DemoMail($mailData));
                    return redirect('/2fa');
                }
                else
                {
                    if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
                        if (Auth::user()->isPatientUser()) {
                            return redirect('/patient');
                        } else {
                            return redirect('/dashboard');
                        }
                    }
                }
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

        if (!Auth::user()->isDoctorUser())
            abort(403);

        return view('user/dashboard');
    }

    function patient(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }
        $pationtModel = Patient::where('email',Auth::user()->email)->first();
        return view('user/patient',[
            'model'=>$pationtModel
        ]);
    }

    function profile(Request $request)
    {
        if ($request->post()) {
            $name = $request->post('name');
            $password = $request->post('password');
            $enable_2fa = $request->post('enable_2fa',0);
            $file = $request->file('file');
            $id = Auth::id();
            $currentUserModel = User::find($id);
            if (strlen($password)) {
                $currentUserModel->name = $name;
            }
            $currentUserModel->enable_2fa = $enable_2fa;
            if ($file) {
                $uploaded_file = (new Files())->upload($file, User::class, $id);
                $currentUserModel->profile_file_id = $uploaded_file->id;
            }
            if (strlen(trim($password))) {
                $currentUserModel->password = Hash::make($password);
            }
            $currentUserModel->save();
            return redirect('/profile');
        } else {
            $model = User::find(Auth::id());
            $file = Files::find($model->profile_file_id);
            return view('user/profile', [
                'model' => $model,
                'file' => $file,
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

    function two_fa(Request $request){
        $email = session('2fa_email');
        if($email)
        {
            $u = User::where('email' , $email)->first();
            if($request->post())
            {
                $code = $request->post('code');
                if($u->two_fa_code == $code)
                {
                    Auth::login($u,true);
                    if (Auth::user()->isPatientUser()) {
                        return redirect('/patient');
                    } else {
                        return redirect('/dashboard');
                    }
                }

            }
            return view('user/two_fa', [
                'email' => $email,
            ]);

        }

    }
}
