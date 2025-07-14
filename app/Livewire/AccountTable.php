<?php

namespace App\Livewire;
use App\Models\Account;
use Livewire\Component;

class AccountTable extends Component
{
    public $accounts;
    public $selectedAccount;
    public $showModal = false;

    public function mount()
    {
        $this->accounts = Account::latest()->get();
    }

    public function showDetail($id)
    {
        $this->selectedAccount = Account::findOrFail($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedAccount = null;
    }

    public function render()
    {
        $accounts = Account::latest()->get();

        return view('livewire.account-table', [
            'accounts' => $accounts
        ])->layout('layouts.app');
    }
}