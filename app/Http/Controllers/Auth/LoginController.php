<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Auth;
use View;
use Validator;
use Input;
use App\model\Currency;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
//use Request;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

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

    public function login(Request $request) {
        $credentials = array('email'=> $request->input('email'), 'password'=>$request->input('password'),
            'active_status' => '1','status' => '1');
        $remember = true;
        if(Auth::attempt($credentials)){
            $newCurr = Currency::firstRow('active_status','1');
            session(['currency' => $newCurr]);
            return redirect()->route('dashboard')->with('message', '');
        }

        /*if(Auth::user()->active_status == 1 && Auth::user()->status == 1){
            return Redirect::to('dashboard')->with('message', 'welcome.');
        }*/

        return redirect()->route('login')
            ->with('message','**Incorrect Email/Password, please try again**');


    }

    public function signout(){
        session()->forget('currency');
        Auth::logout();
        return redirect()->route('login')->with('message','You\'ve signed out');
    }


}
