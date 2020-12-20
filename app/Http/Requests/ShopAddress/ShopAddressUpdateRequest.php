<?php

namespace App\Http\Requests\ShopAddress;

use Illuminate\Foundation\Http\FormRequest;

class ShopAddressUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role === 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city_id' => ['required', 'numeric', 'exists:cities,city_id'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'phone_number' => ['required', 'max:15', 'starts_with:62,0,08'],
            'detail' => ['required', 'string', 'max:255']
        ];
    }
}
