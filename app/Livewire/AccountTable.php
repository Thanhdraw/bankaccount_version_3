<?php

namespace App\Livewire;
use App\Models\Account;
use Livewire\Component;

class AccountTable extends Component
{

    public function render()
    {
        $accounts = Account::latest()->get();

        return view('livewire.account-table', [
            'accounts' => $accounts
        ])->layout('layouts.app');
    }
}
