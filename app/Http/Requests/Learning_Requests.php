<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Regex_Pattern;
use App\Models\Big_theme;

class Learning_Requests extends FormRequest
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
    
        //大テーマを配列に直す 

        $big_array=[];
        $big_theme_base=Big_theme::select("big_theme");
        foreach($big_theme_base as $b){
            $big_theme_base[]=$b->big_theme;
        }

        $rgxstr=implode("|",$big_array)."|Q&A";

        return [
            "big_theme"=>[
                "required",
                "regex:/^(${rgxstr})$/"
            ],
            
            "small_theme"=>[
                "required",
                "regex:/^[a-zA-z]+[a-zA-Z0-9]*$/"
            ],
        ];
    }

    public function messages(){
        return [
            "big_theme.required"=>"入力してください",
            "small_theme.required"=>"入力してください",
            "big_theme.regex"=>"指定の型と違います",
            "small_theme.regex"=>"指定の型と違います"
        ];
    }


}
