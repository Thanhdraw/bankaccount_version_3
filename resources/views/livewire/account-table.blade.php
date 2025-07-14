<div class="max-w-6xl p-4 mx-auto">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Danh sách tài khoản</h2>
        <a href="{{ route('accounts.create') }}"
            class="px-4 py-2 text-white transition bg-blue-600 rounded hover:bg-blue-700">
            + Tạo tài khoản
        </a>
    </div>
    <table class="w-full border-collapse table-auto">
        <thead>
            <tr class="text-left bg-gray-200">
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Chủ tài khoản</th>
                <th class="px-4 py-2 border">Số tài khoản</th>
                <th class="px-4 py-2 border">Loại</th>
                <th class="px-4 py-2 border">Số dư</th>
                <th class="px-4 py-2 border">Trạng thái</th>
                <th class="px-4 py-2 border">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($accounts as $index => $account)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                <td class="px-4 py-2 border">{{ $account->account_holder_name }}</td>
                <td class="px-4 py-2 border">{{ $account->account_number ?? '---' }}</td>
                <td class="px-4 py-2 border">
                    @if ($account->type === 10)
                    Tiết kiệm
                    @elseif ($account->type === 20)
                    Thanh toán
                    @else
                    Không rõ
                    @endif
                </td>
                <td class="px-4 py-2 border">{{ number_format($account->balance) }}₫</td>
                <td class="px-4 py-2 border">
                    @if ($account->status)
                    <span class="text-green-600">Hoạt động</span>
                    @else
                    <span class="text-red-600">Tạm khóa</span>
                    @endif
                </td>
                <td class="px-4 py-2 border">
                    <button wire:click="showDetail({{ $account->id }})" class="text-blue-600 hover:underline">
                        Chi tiết
                    </button>
                </td>


            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-2 text-center text-gray-500">Không có tài khoản nào</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($showModal && $selectedAccount)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md p-6 bg-white rounded shadow">
            <h3 class="mb-4 text-lg font-semibold">Chi tiết tài khoản</h3>
            <p><strong>Chủ tài khoản:</strong> {{ $selectedAccount->account_holder_name }}</p>
            <p><strong>Số tài khoản:</strong> {{ $selectedAccount->account_number }}</p>
            <p><strong>Loại:</strong> {{ $selectedAccount->type->label() }}</p>
            <p><strong>Số dư:</strong> {{ number_format($selectedAccount->balance) }}₫</p>
            <p><strong>Trạng thái:</strong> {{ $selectedAccount->status ? 'Hoạt động' : 'Tạm khóa' }}</p>

            <div class="mt-4 text-right">
                <button wire:click="closeModal" class="px-4 py-2 text-white bg-gray-600 rounded hover:bg-gray-700">
                    Đóng
                </button>
            </div>
        </div>
    </div>
    @endif
</div>