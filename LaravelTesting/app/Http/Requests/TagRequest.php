<?php

/**
 * Tag Request
 *
 * @category   Tag
 * @package    CoRA-Requests
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2020
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 3.0.0
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
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
        return [
            'name' => 'required|max:32',
            'description'  => 'nullable|max:255',
            'type' => ["sometimes", "nullable", Rule::in(['Specimen', 'DNA', 'Isotope', 'Media'])],
            'category' => 'nullable|alpha_num|max:32',
            'color' => 'nullable|max:32',
            'icon' => 'nullable|max:64',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
