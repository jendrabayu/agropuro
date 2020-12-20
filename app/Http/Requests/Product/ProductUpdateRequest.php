<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductUpdateRequest extends FormRequest
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
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
            'nama'  => ['required', 'string', ' max:100', 'unique:products,nama,' . $this->product->id],
            'slug'  => ['required', 'string'],
            'deskripsi'  => ['nullable', 'string'],
            'deskripsi_singkat'  => ['nullable', 'string'],
            'gambar'  => ['nullable', 'max:1000', 'mimes:jpeg,bmp,png,jpg'],
            'stok' => ['required', 'integer'],
            'harga' => ['required', 'numeric', 'min:1'],
            'berat' => ['required', 'numeric', 'min:1', 'max:30000'],
            'diarsipkan'  => ['required', 'boolean'],
        ];
    }


    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->nama),
            'diarsipkan' => $this->action === 'simpan' ? false : true,
        ]);
    }
}
