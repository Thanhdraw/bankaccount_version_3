<?php

namespace App\Repository\Interfaces;

use App\Models\Account;


interface AccountRepositoryInterface
{
    public function findAccount($id);

    public function findAccountNumber(string $accountNumber);

    public function deposit(Account $account, float $amount);

    public function withdraw(Account $account, float $amount);
}