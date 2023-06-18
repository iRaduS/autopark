<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\AlphaSpaces;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('update employee');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'last_name' => ['required', new AlphaSpaces()],
            'first_name' => ['required', new AlphaSpaces()],
            'personal_code' => ['required', 'numeric', 'digits:13'],
            'title' => ['required', new AlphaSpaces()],
            'employment_date' => ['required', 'date'],
            'unemployment_date' => ['date']
        ];
    }
}
