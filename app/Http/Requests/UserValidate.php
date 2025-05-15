<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserValidate extends FormRequest
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
            "name"=>["required","string","max:255"],
            "email"=>["required","email","unique:users,email"],
            // "password" => ["min:8","confirmed"],
            "image" => ["image","mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/gfif","max:2048"],
            // "dob"=>["nullable","date"],
            // "gender"=>["in:0,1,2"],
            // "number"=>["nullable","numeric","digits:11"]
        ];
    }
    public function attributes():array{
        return[
            "name"=>"Name",
            "email"=>"email",
            "image"=>"image",
            // "password"=>"password"
        ];
    }

    public function messages():array{
        return[
            "image.max"=>"The file size cannot greater then 2MB",
            "image.mimetypes"=>"The file only accpted in jpg,jpeg,gif,png,gfif",
            "image.image"=>"Only accpted image",
            // 'number.numeric' => 'The number must be a valid number.',
            // 'dob.date' => 'The date of birth must be a valid date.',
        ];
    }

}
