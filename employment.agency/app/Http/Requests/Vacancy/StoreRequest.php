<?php

namespace App\Http\Requests\Vacancy;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'vacancy_name' => 'required|string|max:255',
            'workers_amount' => 'required|numeric|max:99999999999',
            'organization_id' => 'required|numeric|max:99999999999999999999',
            'salary' => 'required|numeric|max:99999999999'
        ];
    }
}
