<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class categoryValidate extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "cname"=>["required","string","max:255"],
            "cslug"=>["required","string","max:255","unique:categories,cslug"],
            "cimage" => ["image","mimes:png,gif","max:2048"],
        ];
    }

    public function attributes():array{
        return[
            "cname"=>"Name",
            "cslug"=>"Slug",
            "cimage"=>"image"

        ];
    }

    public function messages():array{
        return[
            "cimage.max"=>"The file size cannot greater then 2MB",
            "cimage.mimes"=>"The file only accpted in jpg,jpeg,gif,png",
            "cimage.image"=>"Only accpted image",
        ];
    }

}
