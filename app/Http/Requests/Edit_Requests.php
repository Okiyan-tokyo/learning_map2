<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Edit_Requests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        return [
            "after_edit_name"=>"requied"
        ];
    }

    public function massages()
    {
        return [
            "after_edit_name.requied"=>"名前が入力されていません"
        ];
    }
}
