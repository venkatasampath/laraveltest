<?php

/**
 * Change Password Controller
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

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Hash;
use Session;
use App\Http\Traits\PasswordsTrait;
use App\PasswordHistory;

/**
 * Class ChangePasswordController
 * @package App\Http\Controllers\Auth
 */
class ChangePasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Change Password Controller
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
        parent::__construct();
        $this->middleware('web');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        return view('auth.passwords.change', $this->viewData);
    }

    /**
     * Changes the password for the current user.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function changePassword(Request $request)
    {
        if (Auth::check())
        {
            $user = Auth::user();

            $Password_Requirements = PasswordsTrait::getPasswordRequirements();

            $rules = array(
                'old_password' => 'required',
                'password' => $Password_Requirements,
            );

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return view('auth.passwords.change', $this->viewData)->withErrors($validator);
            } else {

                // Check the user has entered the correct old passsword
                if ( !(Hash::check($request->get('old_password'), $user->password)) ) {
                    return redirect()->back()->withErrors(trans('messages.error_old_password_mismatch'));
                }

                // Check the old passsword is not the same as the new password
                if( strcmp($request->get('old_password'), $request->get('password')) == 0 ) {
                    return redirect()->back()->withErrors("New Password cannot be same as your current password. Please choose a different password.");
                }

                // Check Password History
                $passwordHistories = $user->passwordHistories()->take(config('auth.passwords.numPasswordHistory'))->get();
                foreach($passwordHistories as $passwordHistory) {
                    if (Hash::check($request->get('password'), $passwordHistory->password)) {
                        // The password matches one of the recent passowrd histories
                        return redirect()->back()->withErrors("Your new password can not be same as any of your recent passwords. Please choose a new password.");
                    }
                }

                // Change Password
                $user->password = bcrypt($request->get('password'));
                $user->password_updated_at = Carbon::now();
                $user->save();

                // Entry into Password History
                $passwordHistory = PasswordHistory::create([
                    'user_id' => $user->id,
                    'password' => bcrypt($request->get('password'))
                ]);

                Session::flash('flash_message', trans('messages.success_password_changed'));
                return redirect()->back()->with("success", trans('messages.success_password_changed'));
            }
        }
    }
}
