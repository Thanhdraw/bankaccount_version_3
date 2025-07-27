<?php

namespace App\Services\Account;

use App\Enums\StatusAccount;
use App\Enums\TransactionType;
use App\Models\Account;
use App\Models\Transaction;
use App\Repository\Eloquents\AccountRepository;
use App\Repository\Eloquents\TransactionRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class AccountService
{

    public function __construct(
        protected Account $account,
        protected TransactionRepository $transactionRepository,
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

            $balanceBefore = $account->balance;

            $this->accountRepository->deposit($account, $amount);

            $account->refresh();

            $balanceAfter = $account->balance;


            $this->transactionRepository->createTransaction([
                'account_id' => $account->id,
                'transaction_type' => TransactionType::Deposit,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'Nạp tiền vào tài khoản',
                'reference_account_id' => null,
                'reference_number' => Str::random(10),
            ]);

            DB::commit();

            return true;

        } catch (\Throwable $th) {

            DB::rollBack();

            throw $th;
        }
    }

    public function withdraw($accountNumber, $amount)
    {
        try {
            DB::beginTransaction();

            $account = $this->accountRepository->findAccountNumber($accountNumber);

            $balanceBefore = $account->balance;

            $this->accountRepository->withdraw($account, $amount);

            $account->refresh();

            $balanceAfter = $account->balance;

            $this->transactionRepository->createTransaction([
                'account_id' => $account->id,
                'transaction_type' => TransactionType::Withdraw,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'Rút tiền vào tài khoản',
                'reference_account_id' => null,
                'reference_number' => Str::random(10),
            ]);

            DB::commit();

            return true;

        } catch (\Throwable $th) {

            DB::rollBack();

            throw $th;
        }
    }

    public function accountTransaction(array $data, $accountNumber)
    {

        if ($accountNumber == $data['receiver_account']) {
            return redirect()->back()->with('error', 'Bạn không thể chuyển tiền cho chính mình!');
        }

        $sender = $this->accountRepository->findAccountNumber($accountNumber);
        $reciever = $this->accountRepository->findAccountNumber($data['receiver_account']);

        if (!$reciever) {
            return redirect()->back()->with('error', 'Tài khoản người nhận không tồn tại.');
        }

        if ($sender->balance < $data['amount']) {
            return redirect()->back()->with('error', 'Số dư không đủ để thực hiện giao dịch.');
        }

        DB::beginTransaction();
        try {
            $balanceBefore = $sender->balance;

            $sender->balance -= $data['amount'];
            $sender->save();

            $balanceAfter = $sender->balance;




            $reciever->balance += $data['amount'];
            $reciever->save();


            $this->transactionRepository->createTransaction([
                'account_id' => $sender->id,
                'transaction_type' => TransactionType::TransferOut,
                'amount' => $data['amount'],
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'Chuyển khoản',
                'reference_account_id' => $reciever->id,

            ]);
            $this->transactionRepository->createTransaction([
                'account_id' => $reciever->id,
                'transaction_type' => TransactionType::TransferIn,
                'amount' => $data['amount'],
                'balance_before' => $reciever->balance - $data['amount'],
                'balance_after' => $reciever->balance,
                'description' => 'Chuyển khoản',
                'reference_account_id' => $sender->id,

            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Chuyển khoản thành công.',
            ];

        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

}