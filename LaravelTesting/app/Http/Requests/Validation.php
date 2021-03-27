<?php namespace App\Http\Requests;

use Illuminate\Validation\Validator;

class Validation extends Validator {

    public function validateAlphaNumDashSpace($attribute, $value)
    {
        return preg_match('/^[a-zA-Z0-9 -]+$/i', $value);
    }
}