<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutConfirmRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:50',
            'address'        => 'required|string|max:200',
            'tel'            => 'required|digits_between:10,11',
            'email'          => 'required|email',

            // 決済方法（credit or cod）
            'payment_method' => 'required|in:credit,cod',

            // クレジットカード選択時のみ必須
            'card_number'    => 'required_if:payment_method,credit|digits_between:13,16',
            'card_exp'       => 'required_if:payment_method,credit|string|max:7', // MM/YY など
            'card_name'      => 'required_if:payment_method,credit|string|max:50',
        ];
    }
}
