<?php

namespace App\Services\Account;

use App\Enums\StatusAccount;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountService
{

    public function createAccount(array $data)
    {
        return Account::create([
            'account_holder_name' => $data['account_holder_name'],
            'type' => $data['type'],
            'balance' => $data['balance'],
            'status' => StatusAccount::Open,
            'user_id' => Auth::id(),
        ]);
    }
}