<?php

/**
 * Password Expiration Controller
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

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Session;
use App\Http\Traits\PasswordsTrait;
use App\PasswordHistory;
use App\PasswordSecurity;
use Log;

class PasswordExpirationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Expiration Controller
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
     * Show the application's password expiration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPasswordExpirationForm(Request $request) {
        $password_expired_id = $request->session()->get('password_expired_id');
        if(!isset($password_expired_id)){
            return redirect('/login');
        }
        return view('auth.passwords.expiration');
    }

    /**
     * Changes the password for the current user.
     *
     * @param  \Illuminate\Http\Request
     * @return void
     */
    public function postPasswordExpiration(Request $request) {
        $password_expired_id = $request->session()->get('password_expired_id');
        if(!isset($password_expired_id)){
            return redirect('/login');
        }

        $user = User::find($password_expired_id);
        if (!(Hash::check($request->get('current-password'), $user->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            // Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:10|confirmed',
        ]);

        // Check Password History
        $passwordHistories = $user->passwordHistories()->take(config('auth.passwords.numPasswordHistory'))->get();
        foreach($passwordHistories as $passwordHistory) {
            if (Hash::check($request->get('new-password'), $passwordHistory->password)) {
                // The password matches one of the recent passowrd histories
                return redirect()->back()->withErrors("Your new password can not be same as any of your recent passwords. Please choose a new password.");
            }
        }

        // Change Password
        $user->password = bcrypt($request->get('new-password'));
        $user->password_updated_at = Carbon::now();
        $user->last_login_at = Carbon::now();
        $user->number_of_logins += 1;
        $user->save();

        // Entry into Password History
        $passwordHistory = PasswordHistory::create([
            'user_id' => $user->id,
            'password' => bcrypt($request->get('new-password'))
        ]);

        // Update password updated at timestamp
        // If user does not have a passwordSecurity record created as yet, go ahead and create one.
        $passwordSecurity = $user->passwordSecurity;
        if ($passwordSecurity === null) {
            Log::info(__METHOD__.' - '.$user->name.' No Password Security Record found');
            $passwordSecurity = PasswordSecurity::create([
                'user_id' => $user->id,
                'password_expiry_days' => config('auth.passwords.expiryDays'),
                'password_updated_at' => Carbon::now(),
            ]);
        }

        $passwordSecurity->password_updated_at = Carbon::now();
        $passwordSecurity->save();
        return redirect('/login')->with("status","Password changed successfully, You can now login !");
    }
}

