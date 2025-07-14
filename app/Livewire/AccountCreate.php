<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;

class AccountCreate extends Component
{
    public $account_holder_name;
    public $type;
    public $initial_deposit;



    public function createAccount()
    {
        $this->validate([
            'account_holder_name' => 'required|string|max:255',
            'type' => 'required|in:10,20',
            'initial_deposit' => 'required|numeric|min:0',
        ]);

        try {
            Account::create([
                'user_id' => auth()->id(),
                'account_holder_name' => $this->account_holder_name,
                'type' => $this->type,
                'balance' => $this->initial_deposit,
                'status' => 10,
            ]);

            $this->dispatch(
                'swal:success',
                title: 'Thành công!',
                text: 'Tài khoản đã được tạo!'
            );


            $this->reset();
            $this->redirect(route('accounts.index'));

        } catch (\Exception $e) {
            $this->dispatch(
                'swal:error',
                title: 'Thất bại!',
                text: 'Lỗi!' . $e->getMessage()
            );

        }
    }

    public function render()
    {
        return view('livewire.account-create')
            ->layout('layouts.app');
    }

}