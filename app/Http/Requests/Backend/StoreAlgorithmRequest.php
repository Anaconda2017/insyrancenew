<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlgorithmRequest extends FormRequest
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
            'algorithm_title' => 'required',
            'algorithm_status' => 'required',
            'algorithm_image' => 'required|mimes:jpg,jpeg,png,svg',
        ];
    }
}
