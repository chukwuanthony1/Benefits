<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Request;
use App\VerifyUser;

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
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        //exit;
        if (\Auth::user()->verified != 1) {
            auth()->logout();
            Request::session()->flash('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
            return "/login";
        }else if(\Auth::user()->status != 1){
            auth()->logout();
            Request::session()->flash('warning', 'This account has been deactivated or account not yet approved.');
            return "/login";
        }else if (\Auth::user()->roles[0]['name'] == 'admin') {
            return "/admin/dashboard/";
            // or return route('routename');
        }elseif(\Auth::user()->roles[0]['name'] == 'company'){
            return "/company/dashboard/";
        }elseif(\Auth::user()->roles[0]['name'] == 'merchant'){
            return "/merchant/dashboard/";
        }elseif(\Auth::user()->roles[0]['name'] == 'company_staff'){
            //var_dump(\Auth::user());exit;
            return "/benefit/home";
        }else{
            return "/login";
        }

        //return "/home";
        // or return route('routename');
    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }

        return redirect('/login')->with('status', $status);
    }

    public function showLoginForm(Request $request){
        return view('auth/login');
    }
}
