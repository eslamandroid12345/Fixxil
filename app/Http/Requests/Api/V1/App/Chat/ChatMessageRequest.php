<?php

namespace App\Http\Requests\Api\V1\App\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChatMessageRequest extends FormRequest
{
    private $file = [

        'IMAGE' => [
            'file' => ['required', 'image', 'max:10000']
        ],
        'TEXT' => [
            'content' => ['required', 'string'],
        ],
        'FILE' => [
            'file' => ['required', 'mimes:pdf,doc,docx,ppt,pptx', 'max:10000']
        ],
        'AUDIO' => [
            'file' => ['required', 'mimes:mp3,m4a,mp4a,mp4,webm', 'max:10000']
        ],
    ];

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
            return [
                'type' => ['required', Rule::in(['TEXT', 'IMAGE', 'AUDIO', 'FILE'])],
                ...$this->file[$this->type],
            ];
    }
}
