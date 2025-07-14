<div>
    @if($showModal && $account)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md p-6 bg-white rounded shadow">
            <h3 class="mb-4 text-lg font-semibold">Chi tiết tài khoản</h3>
            <p><strong>Chủ tài khoản:</strong> {{ $account->account_holder_name }}</p>
            <p><strong>Số tài khoản:</strong> {{ $account->account_number }}</p>
            <p><strong>Loại:</strong> {{ \App\Enums\TypeAccount::tryFrom($account->type)?->label() ?? 'Không rõ' }}</p>
            <p><strong>Số dư:</strong> {{ number_format($account->balance) }}₫</p>
            <p><strong>Trạng thái:</strong> {{ $account->status ? 'Hoạt động' : 'Tạm khóa' }}</p>

            <div class="mt-4 text-right">
                <button wire:click="closeModal" class="px-4 py-2 text-white bg-gray-600 rounded hover:bg-gray-700">
                    Đóng
                </button>
            </div>
        </div>
    </div>
    @endif
</div>