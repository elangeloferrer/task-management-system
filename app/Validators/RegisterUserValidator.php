<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterUserValidator
{

    public static function validate(Request $request)
    {
        return Validator::make($request->all(), self::rules(), self::messages());
    }

    public static function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z]+$/'
            ],
            'middle_name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z]+$/'
            ],
            'last_name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z]+$/'
            ],
            'username' => [
                'required',
                'unique:users',
                'regex:/^[a-zA-Z0-9_]+$/'
            ],
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],

        ];
    }

    public static function messages(): array
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'first_name.regex' => 'First Name may only contain letters.',
            'middle_name.required' => 'The middle name field is required.',
            'middle_name.regex' => 'Middle Name may only contain letters.',
            'last_name.required' => 'The last name field is required.',
            'last_name.regex' => 'Last Name may only contain letters.',

            'username.required' => 'Username is required.',
            'username.regex' => 'Username may only contain letters, numbers, and underscores.',

            'password.required' => 'You must enter a password.',
            'password.confirmed' => 'The passwords do not match.',
            'password.regex' => 'Password must be at least 8 characters long and include at least one letter, one number, and one special character.',
        ];
    }
}
