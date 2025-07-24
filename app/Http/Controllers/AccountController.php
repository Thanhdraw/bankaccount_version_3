<?php

namespace App\Http\Controllers;

use App\Enums\StatusAccount;
use App\Enums\TransactionType;
use App\Enums\TypeAccount;
use App\Http\Requests\CreateAccount;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\WithdrawRequest;
use App\Models\Account;
use App\Models\Transaction;
use App\Services\Account\AccountService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class AccountController extends Controller
{
    public function __construct(
        protected Account $account,
        protected Transaction $transaction,
        protected AccountService $accountService
    ) {
    }

    public function index()
    {
        $accounts = $this->account->all();

        return view('account.index')

            ->with('accounts', $accounts);
    }

    public function show($id)
    {
        $account = $this->account->findOrFail($id);

        $trasactionHistory = $this->transaction->where('account_id', $id)->get();

        return view('account.show')

            ->with('histories', $trasactionHistory)

            ->with('account', $account);
    }

    public function create()
    {

        return view('account.create')

            ->with('types', TypeAccount::asSelectArray());
    }

    public function store(CreateAccount $request)
    {
        $validated = $request->validated();

        $this->accountService->createAccount($validated);

        return redirect()->route('account.index')

            ->with('success', 'Tạo tài khoản thành công.');
    }

    public function edit($id)
    {
        $account = $this->account->findOrFail($id);

        return view('account.edit')

            ->with('account', $account)

            ->with('types', TypeAccount::asSelectArray());
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'account_holder_name' => [
                'required',
                'string',
                'max:255',
            ],
            'type' => ['required', new Enum(TypeAccount::class)],
            'status' => ['required', new Enum(StatusAccount::class)],
            'balance' => ['nullable', 'numeric', 'min:0'],
        ]);

        $account = Account::findOrFail($id);

        $account->update($data);

        return redirect()

            ->route('account.index')

            ->with('success', 'Cập nhật tài khoản thành công.');
    }

    public function delete($id)
    {
        $data = $this->account->findOrFail($id);

        $data->delete();

        return redirect()->back()->with('success', 'Xoá thành công');
    }

    public function deposit(DepositRequest $request, $accountNumber)
    {
        $validated = $request->validated();

        $account = $this->accountService->deposit(
            $accountNumber,
            (float) $validated['deposit_amount']
        );

        if ($account) {
            return redirect()->back()->with('success', "Nap tien thanh công");
        }
        return redirect()->back()->with('error', "Nap tien that bai");
    }

    public function withdraw(WithdrawRequest $request, $accountNumber)
    {
        $validated = $request->validated();

        $account = $this->accountService->withdraw(
            $accountNumber,
            (float) $validated['withdraw_amount']
        );
        if ($account) {
            return redirect()->back()->with('success', 'Rút tiền thành cồng');
        }
        return redirect()->back()->with('error', 'Rút tiền thất bại');
    }
}