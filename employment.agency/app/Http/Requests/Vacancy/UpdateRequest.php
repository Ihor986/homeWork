<?php

namespace App\Http\Requests\Vacancy;

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
            'vacancy_name' => 'sometimes|string|max:255',
            'workers_amount' => 'sometimes|numeric|max:99999999999',
            'organization_id' => 'sometimes|numeric|max:99999999999999999999',
            'salary' => 'sometimes|numeric|max:99999999999'
        ];
    }
}
