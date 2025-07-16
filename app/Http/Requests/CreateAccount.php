<?php

namespace App\Http\Requests;

use App\Enums\StatusAccount;
use App\Enums\TypeAccount;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
class CreateAccount extends CustomRequest
{
    /**
     * Validation rules for POST method (Create)
     */
    protected function methodPost()
    {

        return [
            'account_holder_name' => [
                'required',
                'string',
                'max:255',
                'unique:accounts,account_holder_name'
            ],
            'type' => ['required', 'integer'],
            'balance' => ['required', 'numeric', 'min:0'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Account,id'],
            'account_holder_name' => [
                'required',
                'string',
                'max:255',
            ],
            'type' => ['required', new Enum(TypeAccount::class)],
            'status' => ['required', new Enum(StatusAccount::class)],
            'balance' => ['nullable', 'numeric', 'min:0'],
        ];
    }
    public function messages(): array
    {
        return [
            'account_holder_name.required' => 'Tên chủ tài khoản là bắt buộc.',
            'account_holder_name.unique' => 'Tên chủ tài khoản đã tồn tại.',
            'type.required' => 'Loại tài khoản là bắt buộc.',
            'balance.required' => 'Số dư là bắt buộc khi tạo tài khoản.',
            'balance.numeric' => 'Số dư phải là số.',
            'balance.min' => 'Số dư không được nhỏ hơn 0.',
        ];
    }


}