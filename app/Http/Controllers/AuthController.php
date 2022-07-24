<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\{Auth, Hash, Session};
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/');
        } else {
            return view('auth.login', ['title' => 'Login']);
        }
    }
    public function register()
    {
        if (Auth::check()) {
            return redirect('/');
        } else {
            return view('auth.register', ['title' => 'Register']);
        }
    }
    public function forgotpassword()
    {
        if (Auth::check()) {
            return redirect('/');
        } else {
            return view('auth.forgotpassword', ['title' => 'Forgot Password']);
        }
    }

    public function actionlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::Attempt($data)) {
            $user = User::where('email', $request->input('email'))->first();
            session(['user' => $user]);
            return redirect('/');
        } else {
            Session::flash('danger', 'Wrong Password');
            return redirect('/login');
        }
    }

    public function actionregister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        Session::flash('info', 'Registration is successfully!');
        return redirect('/login');
    }
    public function actionforgotpassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        $token = Str::random(10);
        $user = User::where('email', '=', $request->input('email'))->first();
        $user->remember_token = $token;
        $user->save();
        app('App\Http\Controllers\MailController')->index([
            'to' => $user->email,
            'title' => 'Reset Password',
            'page' => 'resetpassword',
            'data' => [
                'name' => $user->name,
                'url' => route("resetpassword", ['email' => $user->email, 'token' => $token])
            ]
        ]);
        return view('auth.checkemail', ['title' => 'Email Set']);
    }

    public function resetpassword($email, $token)
    {
        $user = User::where('email', '=', $email)->where('remember_token', '=', $token)->first();
        if ($user) {
            $tokenTime = strtotime($user->updated_at) + (5 * 60);
            if (time() > $tokenTime) {
                $user->remember_token = NULL;
                $user->save();
                Session::flash('warning', 'The url is expired!');
                return redirect('/forgotpassword');
            } else {
                session(['user' => $user]);
                return view('auth.resetpassword', ['title' => 'Reset Password']);
            }
        } else {
            Session::flash('danger', 'The url is broken!');
            return redirect('/login');
        }
    }

    public function actionresetpassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
        $user = User::where('email', '=', session('user')->email)->first();
        $user->remember_token = NULL;
        $user->password = Hash::make($request->input('password'));
        $user->save();
        Session::flash('success', 'Password successfully reset!');
        return redirect('/login');
    }


    public function actionlogout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/login');
    }
}
