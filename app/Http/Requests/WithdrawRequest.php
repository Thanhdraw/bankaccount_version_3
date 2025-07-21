<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
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
            'withdraw_amount' => ['required', 'numeric', 'min:500000'],
        ];
    }

    public function messages()
    {
        return [
            'withdraw_amount.min' => 'Số tiền tối thiểu là 500000',
            'withdraw_amount.required' => 'Vui lòng nhập số tiền cần rút',
            'withdraw_amount.numeric' => 'Số tiền phải là một số',
        ];
    }
}
