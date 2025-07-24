<?php

namespace App\Repository\Interfaces;

use App\Models\Account;
use App\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function createTransaction(array $data): Transaction;




}