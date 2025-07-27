<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountTransaction extends FormRequest
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
            "receiver_account" => ['required', 'numeric'],
            "amount" => ['required', 'numeric', 'min:20000'],
            "note" => ['nullable']
        ];
    }

    public function messages()
    {
       return [
        'receiver_account.numeric' => 'Tai khoan phai la so ',
        'amount.required' => 'So tien can nhap'
       ];
    }
}
