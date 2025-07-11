<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\User;
class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 1; $i <= 5; $i++) {
            Account::create([
                'account_holder_name' => "Người dùng $i",
                'balance' => rand(1_000_000, 5_000_000),
                'user_id' => 1,
                'status' => 1,
                'type' => rand(1, 2),
            ]);
        }

        $this->command->info('✅ Accounts seeded.');
    }
}