<?php

namespace App\Http\Requests\PlantingSchedule;

use Illuminate\Foundation\Http\FormRequest;

class PlantingScheduleStoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3', 'max:250'],
            'start_at' => ['required', 'date', 'date_format:Y-m-d'],
            'end_at' => ['required', 'date', 'date_format:Y-m-d'],
            'information' => ['nullable', 'string']
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
            'title' => 'judul',
            'start_at' => 'tanggal mulai',
            'end_at' => 'tanggal berakhir',
            'information' => 'detail atau infomasi'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([]);
    }
}
