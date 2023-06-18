<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAutovehicle extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('general auto'); //@todo
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['required', 'string', 'max:64'],
            'registration_number' => ['required', 'regex:/((AB)|(AR)|(AG)|B|(BC)|(BH)|(BN)|(BT)|(BV)|(BR)|(BZ)|(CS)|(CL)|(CJ)|(CT)|(CV)|(DB)|(DJ)|(GL)|(GR)|(GJ)|(HR)|(HD)|(IL)|(IS)|(IF)|(MM)|(MH)|(MS)|(NT)|(OT)|(PH)|(SM)|(SJ)|(SB)|(SV)|(TR)|(TM)|(TL)|(VS)|(VL)|(VN)) [0-9]{2,3} [A-Z]{3}/i', 'unique:automobiles,registration_number']
        ];
    }
}
