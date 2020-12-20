<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'city_id' => 'required|integer',
            'name' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone_number' => 'required|string',
            'detail' => 'required|string',
            'is_main' => 'nullable'
        ];
    }


    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'city_id' => 'Kabupaten/Kota',
            'name' => 'nama',
            'phone_number' => 'nomot telepon',
            'detail' => 'detail alamat',
        ];
    }
}
