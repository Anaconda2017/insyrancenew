<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactFormRequest extends FormRequest
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
            'contact_us_form_name' => 'required',
            'contact_us_form_email' => 'required',
            'contact_us_form_phone' => 'required',
            'contact_us_form_job_title' => 'required',
            'contact_us_form_work_place' => 'required',
            'contact_us_form_subject' => 'required',
            'contact_us_form_text' => 'required',
            'user_id' => ''
        ];
    }
}
