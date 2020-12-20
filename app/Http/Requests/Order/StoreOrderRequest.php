<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'bank_account_id' => ['required', 'integer'],
            'subtotal' => ['required'],
            'pesan' => ['nullable', 'string'],
            'courier' => ['required', 'string'],
            'ongkir' => ['required'],
            'address_id' => ['required', 'integer']
        ];
    }
}
