<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Mail\ReportEmail;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/admin/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    function authenticated(Request $request, $user)
    {
        $user->last_login = $user->current_login;
        $user->current_login = now();
        $user->last_login_ip = $request->getClientIp();
        $user->connected = "true";
        $user->save();
        //Mail::to("kazi.sidou.94@gmail.com")->send(new ReportEmail($user));
    }
    protected function redirectTo()
    {
        // if (Auth::user()->is_admin != 'on' || Auth::user()->role->lister_patient == 'on')
        //     $this->redirectTo = '/patient';
        // else if (Auth::user()->is_admin == 'on')
        //     $this->redirectTo = '/admin/user';
        // else if (Auth::user()->is_admin != 'on' || Auth::user()->role->analyse_ph == 'on')
        //     $this->redirectTo = '/analyse';
        // else $this->redirectTo = '/patient';
        $this->redirectTo = '/home';
        return $this->redirectTo;
    }
    public function logout(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->connected = "false";
        $user->save();
        Auth::logout();
        return redirect('/login');
    }
}
