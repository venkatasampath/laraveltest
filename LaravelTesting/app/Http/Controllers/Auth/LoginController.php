<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Hash;
use Session;
use Log;
use Auth;
use App\PasswordSecurity;
use App\PasswordHistory;

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
     * lockoutTime
     *
     * @var
     */
    protected $lockoutTime = 1;

    /**
     * maxLoginAttempts
     *
     * @var
     */
    protected $maxLoginAttempts = 5;

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

        $this->maxLoginAttempts = config('auth.login.maxLoginAttempts');
        $this->lockoutTime = config('auth.login.lockoutTime');
    }

    /**
     * Get the needed authorization credentials from the request.
     * This function overrides the one in traits AuthenticatesUsers.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $request['active'] = true;
        $request['deleted_at'] = null;
        return $request->only(strtolower($this->username()), 'password', 'active', 'deleted_at');
    }

    /**
     * The user has been authenticated.
     * This function is overridden from Trait AuthenticatesUsers
     * This function is called once the user has been authenticated
     * Do any initialization processing that needs to be done for this user here.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        Log::info(__METHOD__.' - '.$user->name);

        $request->session()->forget('password_expired_id');

        // Check if User Account has expired
        if ($this->isExpired($request, $user)) {
            auth()->logout();
            return redirect('/login')->with('error', trans('messages.user_account_expired'));
        }

        // Check if User has been inactive for specified number of days
        if (isset($user->last_login_at)) {
            $last_user_activity_in_days = Carbon::parse($user->last_login_at)->diffInDays(Carbon::now());
            $maxInactiveDays = config('auth.login.maxInactiveDays');
            if($last_user_activity_in_days > $maxInactiveDays) {
                Log::info(__METHOD__.' - '.$user->name . ' - User Account suspended due to inactivity: '. $last_user_activity_in_days.' days');
                auth()->logout();
                return redirect('/login')->with('error', trans('messages.user_account_inactivity_suspension', ['days' => $maxInactiveDays]));
            }
        } else { // First time login in.
            Log::info(__METHOD__.' - '.$user->name.' - First time login');
            // Entry into Password History of first temporary password
            $passwordHistory = PasswordHistory::create(['user_id' => $user->id, 'password' => $user->password]);
            $request->session()->put('password_expired_id',$user->id);
            auth()->logout();
            return redirect('/password/expiration')->with('error', trans('messages.password_must_change'));
        }

        // Perform User Password Security Check
        if (! $this->passwordSecurityCheck($request, $user)) {
            auth()->logout();
            return redirect('password/expiration')->with('message', trans('messages.password_expired'));
        }

        $this->updateLoginInformation($request, $user);
        $user->initialize();
//        return redirect()->intended($this->redirectPath());
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $this->maxLoginAttempts, $this->lockoutTime
        );
    }

    /**
     * Determine if the user account has expired.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return bool
     */
    protected function isExpired(Request $request, $user)
    {
        if ($user->expiration_at->lessThan(Carbon::now())) {
            Log::info(__METHOD__.' - '.$user->name.' - User Account has expired: '.$user->expiration_at);
            return true;
        }
        return false;
    }

    /**
     * Determine if the user account has been inactive for a specified time period.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return bool
     */
    protected function hasBeenInactive(Request $request, $user)
    {
        return false;
    }

    /**
     * Perform user password security check.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return bool
     */
    protected function passwordSecurityCheck(Request $request, $user)
    {
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

        $password_updated_at = $passwordSecurity->password_updated_at;
        $password_expiry_days = $passwordSecurity->password_expiry_days;
        $password_expiry_at = Carbon::parse($password_updated_at)->addDays($password_expiry_days);
        if($password_expiry_at->lessThan(Carbon::now())) {
            Log::info(__METHOD__.' - '.$user->name .' - PasswordSecurity: Password Expired');
            $request->session()->put('password_expired_id',$user->id);
            return false;
        }

        $this->displayDaysBeforePasswordExpirationAlert($request, $user, $password_expiry_at);
        return true;
    }

    /**
     * Determine if we need to display Days before Password Expiration alert message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User    $user
     * @param  datetime     $password_expiry_at
     * @return bool
     */
    protected function displayDaysBeforePasswordExpirationAlert($request, $user, $password_expiry_at)
    {
        $days_before_password_expiration_alert = config('auth.passwords.daysBeforePasswordExpirationAlert');
        $password_expiry_in_10days = Carbon::now()->addDays($days_before_password_expiration_alert); // days before password expiration.
        if($password_expiry_at->lessThan($password_expiry_in_10days)) {
            $days_until_password_expiration = $password_expiry_at->diffInDays(Carbon::now());
            Log::info(__METHOD__.' - '.$user->name.' - PasswordSecurity: Password Expiry in '.$days_until_password_expiration.' days');
            Session::flash('warn', trans('messages.password_expiration_in_days', ['days' => $days_until_password_expiration]));
        }
    }

    /**
     * Update user record with .
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User    $user
     * @return bool
     */
    protected function updateLoginInformation($request, $user)
    {
        Log::info(__METHOD__.' - '.$user->name);
        $user->number_of_logins += 1;
        $user->last_login_at = Carbon::now();
        $user->last_login_ip_address = $request->ip();
        $user->last_login_device = $request->header('User-Agent');
        $user->save();
    }

}
