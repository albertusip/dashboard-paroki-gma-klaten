<?php

namespace App\Http\Requests;

use App\Exceptions\InvalidParameterException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ValidatePassword extends FormRequest
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
            'old_password' => 'required',
            'new_password' => 'required'
        ];
    }

    /**
     * Handle a failed validation attempt
     *
     * @param Validator $validator
     * @throws InvalidParameterException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new InvalidParameterException();
    }
}
