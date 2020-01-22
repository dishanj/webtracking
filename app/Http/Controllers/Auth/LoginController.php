<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Sentinel;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginView()
    {
        try{
            if(!Sentinel::check())
                return view('login.login');
            else
                return redirect('/');
        }catch(\Exception $e){
            return view('login.login')->withErrors(['login' => $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        $credentials = array(
            'email'    => Input::get('email'),
            'password' => Input::get('password')
        );
        $remember = false;
        try{
            $user = Sentinel::authenticate($credentials, $remember);
            if ($user){
                return redirect('/');
            }else{
                return redirect('user/login')->with('error','Incorrect Username/Password');
            }

        }catch(\Cartalyst\Sentinel\Checkpoints\checkThrottlingException $e){
            return redirect('user/login')->with('error',$e->getMessage());
        }
        
        // return redirect()->route('login')->withErrors(array('login' => $msg));
        
    }

    public function logout()
    {
        Sentinel::logout();
        return redirect()->route('user.login');
    }
}
