<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuideLineMainRequest extends FormRequest
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
            'guide_line_title' => 'required',
            'guide_line_overview' => 'required',
            'guest_status' => 'required' ,
            'guide_line_file' => 'mimes:jpg,jpeg,png,svg'
        ];
    }
}
