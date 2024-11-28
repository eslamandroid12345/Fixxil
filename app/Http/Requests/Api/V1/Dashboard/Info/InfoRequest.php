<?php

namespace App\Http\Requests\Api\V1\Dashboard\Info;

use Illuminate\Foundation\Http\FormRequest;

class InfoRequest extends FormRequest
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
            'images'=>$this->images?['required','array']:'nullable',
            'images.*'=>['image','required'],
            'text' => $this->text ? ['required','array'] : 'nullable',
            'text.*' => ['required']
        ];
    }
}
