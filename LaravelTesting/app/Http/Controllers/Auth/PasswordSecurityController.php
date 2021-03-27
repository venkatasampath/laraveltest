<?php

/**
 * Password Security Controller
 *
 * @category   Controllers
 * @package    CoRA-Controllers
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use App\PasswordSecurity;
use Validator;
use Session;
use Log;

class PasswordSecurityController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Security Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Show the application's 2fa form.
     *
     * @return \Illuminate\Http\Response
     */
    public function show2faForm(Request $request) {
        $user = Auth::user();
        $google2fa_url = "";
        if($user->passwordSecurity()->exists()) {
            $google2fa = app('pragmarx.google2fa');
            $google2fa_url = $google2fa->getQRCodeGoogleUrl(
                'CoRA', $user->email, $user->passwordSecurity->google2fa_secret
            );
        }
        $data = array( 'user' => $user, 'google2fa_url' => $google2fa_url );
//        dd([$data, $user]);
        return view('auth.2fa')->with('data', $data);
    }

    /**
     * Generate 2fa Secret for the current user.
     *
     * @param  \Illuminate\Http\Request
     * @return void
     */
    public function generate2faSecret(Request $request) {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa'); // Initialise the 2FA class

        if($user->passwordSecurity()->exists()) {
            $user->passwordSecurity->google2fa_enable = false;
            $user->passwordSecurity->google2fa_secret = $google2fa->generateSecretKey();
            $user->passwordSecurity->save();
        } else {
            // Add the secret key to the registration data
            PasswordSecurity::create([
                'user_id' => $user->id,
                'password_updated_at' => Carbon::now(),
                'password_expiry_days' => config('auth.passwords.expiryDays'),
                'google2fa_enable' => 0,
                'google2fa_secret' => $google2fa->generateSecretKey(),
            ]);
        }
        return redirect('/2fa')->with('success',"Secret Key is generated, Please verify Code to Enable 2FA");
    }

    /**
     * Enable 2fa for the current user.
     *
     * @param  \Illuminate\Http\Request
     * @return void
     */
    public function enable2fa(Request $request) {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $secret = $request->input('verify-code');

        $valid = $google2fa->verifyKey($user->passwordSecurity->google2fa_secret, $secret);
        if($valid){
            $user->passwordSecurity->google2fa_enable = 1;
            $user->passwordSecurity->save();
            return redirect('2fa')->with('success',"2FA is Enabled Successfully.");
        } else {
            return redirect('2fa')->with('error',"Invalid Verification Code, Please try again.");
        }
    }

    /**
     * Disable 2fa for the current user.
     *
     * @param  \Illuminate\Http\Request
     * @return void
     */
    public function disable2fa(Request $request) {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your  password does not matches with your account password. Please try again.");
        }
        $validatedData = $request->validate(['current-password' => 'required',]);

        $user = Auth::user();
        $user->passwordSecurity->google2fa_enable = 0;
        $user->passwordSecurity->save();
        return redirect('/2fa')->with('success',"2FA is now Disabled.");
    }
}

