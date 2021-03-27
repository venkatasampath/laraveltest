<?php
/**
 * Created by PhpStorm.
 * User: 1234
 * Date: 11/3/2017
 * Time: 1:27 PM
 */

namespace App\Http\Traits;

trait PasswordsTrait
{

    public static function getPasswordRequirements()
    {
        $Password_Requirements = 'required|string|confirmed|';

        if (config('auth.passwordstrength.min10'))
            $Password_Requirements .= 'min:10|';
        else
            $Password_Requirements .= 'min:8|';

        if (config('auth.passwordstrength.max'))
            $Password_Requirements .= 'max:128|';

        if (config('auth.passwordstrength.pass_capital_lowercase')) {
            $Password_Requirements .= 'regex:/^(?=.*[a-z])(?=.*[A-Z])';
            if (config('auth.passwordstrength.pass_digit'))
                $Password_Requirements .= '(?=.*\d)';
            if (config('auth.passwordstrength.pass_sp_char'))
                $Password_Requirements .= '(?=.*[$@$!%*?&])';
            $Password_Requirements .= '.+$/';
        }
        elseif (config('auth.passwordstrength.pass_digit')) {
            $Password_Requirements .= 'regex:/^(?=.*\d)';
            if ( config( 'auth.passwordstrength.pass_sp_char'))
                $Password_Requirements .= '(?=.*[$@$!%*?&])';
            $Password_Requirements .= '.+$/';
        }
        elseif (config('auth.passwordstrength.pass_sp_char'))
            $Password_Requirements .= 'regex:/^(?=.*[$@$!%*?&]).+$/';

        return $Password_Requirements;
    }

    public static function getPasswordRequirementText()
    {
        $Password_Requirements = trans('passwords.requirements_min8');

        if (config('auth.passwordstrength.min10'))
        {
            if (config('auth.passwordstrength.pass_capital_lowercase'))
            {
                if (config('auth.passwordstrength.pass_digit')) {
                    if (config('auth.passwordstrength.pass_sp_char')) {
                        $Password_Requirements = trans('passwords.requirements_min10_alphanumeric_spec');
                    } else {
                        $Password_Requirements = trans('passwords.requirements_min10_alphanumeric');
                    }
                } else {
                    $Password_Requirements = trans('passwords.requirements_min10_uplow');
                }
            } else {
                $Password_Requirements = trans('passwords.requirements_min10');
            }
        } else { // else min of 8
            if (config('auth.passwordstrength.pass_capital_lowercase'))
            {
                if (config('auth.passwordstrength.pass_digit')) {
                    if (config('auth.passwordstrength.pass_sp_char')) {
                        $Password_Requirements = trans('passwords.requirements_min_alphanumeric_spec');
                    } else {
                        $Password_Requirements = trans('passwords.requirements_min_alphanumeric');
                    }
                } else {
                    $Password_Requirements = trans('passwords.requirements_min_uplow');
                }
            }
        }
        return $Password_Requirements;
    }
}