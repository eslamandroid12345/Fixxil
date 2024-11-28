<?php

namespace App\Http\Requests\Api\V1\Dashboard\Instruction;

use Illuminate\Foundation\Http\FormRequest;

class InstructionRequest extends FormRequest
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
                    'order_instruction_en' => 'required',
                    'order_instruction_ar' => 'required',
                    'order_used_en' => 'required',
                    'order_used_ar' => 'required',
                ];
    }
}
