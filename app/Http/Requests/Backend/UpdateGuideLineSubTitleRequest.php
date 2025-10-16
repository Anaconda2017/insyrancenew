<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuideLineSubTitleRequest extends FormRequest
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
            'guide_line_subtitle_title' => 'required',
            'guide_line_subtitle_text' => 'required',
            'guide_line_main_id' => 'required',
            'guide_line_title_id' => 'required',
        ];
    }
}
