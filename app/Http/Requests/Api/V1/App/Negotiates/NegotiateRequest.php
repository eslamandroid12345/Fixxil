<?php

namespace App\Http\Requests\Api\V1\App\Negotiates;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NegotiateRequest extends FormRequest
{
    private $type_rules = [
        'accept_offer' => [],
        'cansel_service' => [],
        'offer_price' => [
            'price_type' => ['required', 'in:total,unit'],
            'price' => ['required', 'numeric'],
            'unit_id' => ['required_if:price_type,unit', 'exists:units,id'],
            'num_units_known' => ['required_if:price_type,unit', 'in:0,1'],
            'num_units' => ['required_if_accepted:num_units_known', 'numeric'],
        ],
        'ask_for_discount' => [],
        'discount' => ['price' => ['required', 'numeric', 'lt:old_price'],
            'old_price' => ['nullable', 'numeric']],
        'fix_the_price' => [],
        'go_to_location' => [],
        'start_service' => [],
        'finish_service' => [],
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => ['required', Rule::exists('orders', 'id')],
            'negotiate_type' => ['required', Rule::in(
                ['accept_offer', 'cansel_service', 'offer_price', 'ask_for_discount', 'discount', 'fix_the_price'
                    , 'go_to_location', 'start_service', 'finish_service'])],
            ...$this->type_rules[$this->negotiate_type],
        ];
    }
}
