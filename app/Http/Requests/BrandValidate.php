<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandValidate extends FormRequest
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
            "bname"=>['required','string','max:255'],
            "bslug"=>['required','string','max:255','unique:brands,bslug'],

        ];
    }
    public function attributes():array{
        return [
            "bname"=>"brand",
            "bslug"=>"slug",

        ];
    }
}
