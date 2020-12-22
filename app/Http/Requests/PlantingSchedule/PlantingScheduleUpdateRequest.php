<?php

namespace App\Http\Requests\PlantingSchedule;

use Illuminate\Foundation\Http\FormRequest;

class PlantingScheduleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'information' => ['nullable']
        ];
    }
}
