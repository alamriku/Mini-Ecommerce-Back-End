<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'name'=> ['required', 'string', Rule::unique("products", "name")->ignore($this->product)],
            'price' => 'required|numeric',
            'qty' => 'required|numeric',
            'image' => 'nullable|mimes:jpg,png|max:1000'
        ];
    }
}
