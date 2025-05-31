<?php

namespace App\Helpers\Validations;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CreateTaskValidator
{

    public static function validate(Request $request)
    {
        return Validator::make($request->all(), self::rules(), self::messages());
    }

    public static function rules(): array
    {
        return [
            'title' => [
                'required',
                'string'
            ],
            'description' => [
                'required',
                'string'
            ],
            'status' => [
                'required',
                'string',
            ],
            'priority' => [
                'required',
                'string',
                'in:low,medium,high'
            ],
            'order' => [
                'required',
                'integer'
            ],
        ];
    }

    public static function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'status.required' => 'The status field is required.',
            'status.string' => 'The status must be a valid string.',
            'priority.required' => 'The priority field is required.',
            'priority.string' => 'The priority must be a valid string.',
            'priority.in' => 'Invalid priority value. Allowed values: low, medium, high.',
            'order.required' => 'The order field is required.',
            'order.integer' => 'The order must be an integer.',
        ];
    }
}
