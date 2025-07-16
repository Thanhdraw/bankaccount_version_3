<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Danh sách tài khoản
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm dark:bg-gray-800 sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <td class="px-4 py-2 text-right border">
                        <a href="{{ route('account.create') }}"
                            class="inline-block px-4 py-2 mb-2 text-sm font-medium text-white transition bg-blue-600 rounded hover:bg-blue-700">
                            + Tạo tài khoản
                        </a>
                    </td>

                    <table class="w-full border-collapse table-auto">
                        <thead>
                            <tr class="text-left">
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
                            <tr class="border-b ">
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
                                <td class="text-center">
                                    <span class="font-semibold {{ $account->status->color() }}">
                                        {{ $account->status->label() }}
                                    </span>
                                </td>

                                <td class="px-4 py-2 text-center border">
                                    <div class="flex items-center justify-center space-x-2">

                                        {{-- Nút xem chi tiết --}}
                                        <a href="{{ route('account.show', $account->id) }}"
                                            class="px-3 py-1 text-sm font-medium text-blue-600 transition rounded hover:bg-blue-50 hover:text-blue-800">
                                            Chi tiết
                                        </a>

                                        {{-- Nút chỉnh sửa --}}
                                        <a href="{{ route('account.edit', $account->id) }}"
                                            class="px-3 py-1 text-sm font-medium text-yellow-600 transition rounded hover:bg-yellow-50 hover:text-yellow-800">
                                            Sửa
                                        </a>

                                        {{-- Nút xoá --}}
                                        <form action="{{ route('account.delete', $account->id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa không?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 text-sm font-medium text-red-600 transition rounded hover:bg-red-50 hover:text-red-800">
                                                Xoá
                                            </button>
                                        </form>

                                    </div>
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
            </div>
        </div>
    </div>
    <x-alert />


</x-app-layout>