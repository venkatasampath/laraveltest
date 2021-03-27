<?php

/**
 * User Request
 *
 * @category   User
 * @package    CoRA-Requests
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\PasswordsTrait;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $Password_Requirements = PasswordsTrait::getPasswordRequirements();

        $rules = [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha_dash',
            'email' => 'required|email|max:255|unique:users',
            'role_id' => 'required',
            'cell_phone' => 'nullable|regex:/^[a-zA-Z0-9 -]+$/i',
            'active' => 'nullable|boolean'
        ];

        if ($this['_method'] == 'PATCH') {
            $rules['email'] = 'required|email|max:255';
        } else {
            $rules['password'] = $Password_Requirements;
        }

        return $rules;
    }
}
