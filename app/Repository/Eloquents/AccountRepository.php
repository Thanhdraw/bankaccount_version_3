<?php

namespace App\Repository\Eloquents;

use App\Models\Account;
use App\Repository\Interfaces\AccountRepositoryInterface;
use Exception;


class AccountRepository implements AccountRepositoryInterface
{

    public function __construct(
        protected Account $account
    ) {
    }
    public function findAccount($id)
    {
        return $this->account->findOrFail($id);
    }
    public function findAccountNumber(string $accountNumber)
    {
        return $this->account->where('account_number', $accountNumber)->first();
    }

    public function deposit(Account $account, float $amount)
    {
        return $account->increment('balance', $amount);
    }

    public function withdraw(Account $account, float $amount)
    {
        if (!$account->canWithdraw($amount)) {

            throw new Exception('Không đủ số dư để rút');
        }
        return $account->decrement('balance', $amount);
    }



}