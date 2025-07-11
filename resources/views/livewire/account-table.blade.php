<div class="p-4 max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Danh sách tài khoản</h2>
        <a href="{{ route('accounts.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Tạo tài khoản
        </a>
    </div>
    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-200 text-left">
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
                        <button class="text-blue-600 hover:underline">Chi tiết</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-2 text-center text-gray-500">Không có tài khoản nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
