<?php

namespace App\Services\Account;

use App\Enums\StatusAccount;
use App\Models\Account;
use App\Repository\Eloquents\AccountRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountService
{

    public function __construct(
        protected Account $account,
        protected AccountRepository $accountRepository,
    ) {
    }
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

    public function deposit($accountNumber, $amount)
    {
        try {
            DB::beginTransaction();

            $account = $this->accountRepository->findAccountNumber($accountNumber);

            $this->accountRepository->deposit($account, $amount);

            DB::commit();

            return true;
            
        } catch (\Throwable $th) {

            DB::rollBack();

            throw $th;
        }
    }
}