<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;

class AccountDetail extends Component
{
    public $account;
    public $showModal = false;

    protected $listeners = ['showAccountDetail'];

    public function showAccountDetail($id)
    {
        $this->account = Account::findOrFail($id);
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.account-detail');
    }
}