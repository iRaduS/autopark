<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // @TODO verify if is not admin
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'priority' => 'required|in:URGENT,NORMAL',
            'problem' => 'required|in:ACCOUNT,TECHNIC,OTHER',
            'detailed_problem' => 'required|min:16|max:256|string',
        ];
    }
}
