<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'sometimes|string|max:20',
            'last_name' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|unique:users',
            'password' => 'sometimes|string|min:6|max:20',
            'country' => 'sometimes|string|max:100',
            'city' => 'sometimes|string|max:100',
            'phone' => 'sometimes|string|max:30',
            'role' => 'sometimes|string|in:employer,worker,admin',
        ];
    }
}
