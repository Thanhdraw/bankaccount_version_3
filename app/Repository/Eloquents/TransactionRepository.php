<?php
namespace App\Repository\Eloquents;

use App\Models\Transaction;
use App\Repository\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function __construct(
        protected Transaction $transaction
    ) {
    }
    public function createTransaction(array $data): Transaction
    {
        return $this->transaction->create($data);
    }
}
?>