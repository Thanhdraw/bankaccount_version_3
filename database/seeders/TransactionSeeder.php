<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Account;
use App\Enums\TransactionType;

use Illuminate\Support\Str;
class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = Account::all();

        if ($accounts->isEmpty()) {
            $this->command->warn('⚠️ No accounts found. Please seed accounts first.');
            return;
        }

        foreach ($accounts as $account) {
            for ($i = 0; $i < 5; $i++) {
                $type = collect(TransactionType::cases())->random();

                $amount = rand(10_000, 1_000_000); // Random amount
                $balanceBefore = $account->balance;

                $balanceAfter = match ($type) {
                    TransactionType::Deposit,
                    TransactionType::TransferIn => $balanceBefore + $amount,

                    TransactionType::Withdraw,
                    TransactionType::TransferOut => $balanceBefore - $amount,
                };

                // Tạo transaction
                Transaction::create([
                    'transaction_id' => 'TXN' . now()->format('YmdHis') . rand(1000, 9999),
                    'account_id' => $account->id,
                    'transaction_type' => $type,
                    'amount' => $amount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'description' => 'Giao dịch mẫu: ' . $type->label(),
                    'reference_account_id' => null,
                    'reference_number' => Str::random(10),
                ]);

                // Cập nhật số dư tài khoản sau giao dịch
                $account->balance = $balanceAfter;
                $account->save();
            }
        }

        $this->command->info('✅ Transaction seed completed.');
    }
}