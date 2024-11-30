<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'title' => 'required|distinct|min:3',// distinct means members of the array must be unique
            'category' => 'required',
            'price' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'title' => 'The title field is required.',
            'category' => 'The category field is required.',
            'price' => 'The price field is required.',
        ];
    }
}
