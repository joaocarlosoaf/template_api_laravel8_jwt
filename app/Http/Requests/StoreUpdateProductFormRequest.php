<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateProductFormRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            //'name' => "required|min:3|max:100|unique:products,name,{$this->segment(3)},id",
            'name' => [
                'required',
                'min:3|max:100',
                Rule::unique('products', 'name')->ignore($this->post)
            ],
            'description' => 'max:1000',
            'image' => 'image',
        ];
    }
}
