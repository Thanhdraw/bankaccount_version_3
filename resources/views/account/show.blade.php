<x-app-layout>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-opacity-50">
        <div class="w-full max-w-3xl p-6 bg-white shadow-xl rounded-2xl">
            <h3 class="pb-2 mb-6 text-2xl font-bold text-gray-800 border-b">Chi tiết tài khoản</h3>

            {{-- Thông tin tài khoản --}}
            <div class="mb-6 space-y-4 text-gray-700">
                <div class="flex justify-between">
                    <span class="font-medium">👤 Chủ tài khoản:</span>
                    <span>{{ $account->account_holder_name }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium">🏦 Số tài khoản:</span>
                    <span>{{ $account->account_number }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium">📂 Loại tài khoản:</span>
                    <span>{{ $account->type->label() }}</span>
                </div>
                {{-- @php
                dd($account->getCurrentBalance());
                @endphp --}}
                <div class="flex justify-between">
                    <span class="font-medium">💰 Số dư:</span>
                    <span class="font-semibold text-green-600">{{ number_format($account->getCurrentBalance())
                        }}₫</span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium">🔒 Trạng thái:</span>
                    <span>
                        @if ($account->status)
                        <span class="font-semibold text-green-600">Hoạt động</span>
                        @else
                        <span class="font-semibold text-red-500">Tạm khóa</span>
                        @endif
                    </span>
                </div>
            </div>

            {{-- Tabs chức năng --}}
            <div class="mb-6 border-b border-gray-200">
                <nav class="flex space-x-4" aria-label="Tabs">
                    <button onclick="switchTab('transfer')"
                        class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600 tab-btn">
                        🔁 Chuyển tiền
                    </button>
                    <button onclick="switchTab('deposit')"
                        class="px-4 py-2 text-sm font-medium text-gray-600 border-b-2 border-transparent tab-btn hover:text-green-600 hover:border-green-300">
                        ➕ Nạp tiền
                    </button>
                    <button onclick="switchTab('withdraw')"
                        class="px-4 py-2 text-sm font-medium text-gray-600 border-b-2 border-transparent tab-btn hover:text-yellow-600 hover:border-yellow-300">
                        ➖ Rút tiền
                    </button>
                    <button onclick="switchTab('history')"
                        class="px-4 py-2 text-sm font-medium text-gray-600 border-b-2 border-transparent tab-btn hover:text-purple-600 hover:border-purple-300">
                        📜 Lịch sử
                    </button>
                </nav>
            </div>

            {{-- Nội dung tab --}}
            <div id="tab-content">
                <div id="tab-transfer" class="tab-pane">
                    <h4 class="mb-2 text-lg font-semibold">🔁 Chuyển tiền</h4>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Số tài khoản người nhận</label>
                            <input type="text" name="receiver_account"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-400"
                                placeholder="Nhập số tài khoản">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Số tiền</label>
                            <input type="number" name="amount"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-400"
                                placeholder="VD: 100000">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nội dung</label>
                            <input type="text" name="note"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-400"
                                placeholder="Ví dụ: Thanh toán hóa đơn">
                        </div>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Thực
                            hiện chuyển</button>
                    </form>

                </div>

                <div id="tab-deposit" class="hidden tab-pane">
                    <h4 class="mb-2 text-lg font-semibold">➕ Nạp tiền</h4>
                    <form action="{{ route('account.deposit',$account->account_number) }}" method="POST"
                        class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Số tiền muốn nạp</label>
                            <input type="number" name="deposit_amount"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-green-400"
                                placeholder="VD: 200000">
                        </div>
                        <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Xác
                            nhận nạp
                        </button>
                    </form>

                </div>

                <div id="tab-withdraw" class="hidden tab-pane">
                    <h4 class="mb-2 text-lg font-semibold">➖ Rút tiền</h4>
                    <form action="{{ route('account.withdraw',$account->account_number) }}" method="POST"
                        class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Số tiền muốn rút</label>
                            <input type="number" name="withdraw_amount"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-yellow-400"
                                placeholder="VD: 150000">
                        </div>
                        <button type="submit" class="px-4 py-2 text-white bg-yellow-500 rounded hover:bg-yellow-600">Xác
                            nhận rút</button>
                    </form>

                </div>

                <div id="tab-history" class="hidden tab-pane">
                    <h4 class="mb-2 text-lg font-semibold">📜 Lịch sử giao dịch</h4>

                    @forelse ($histories as $item)
                    @if ($loop->first)
                    <div class="mt-2 overflow-x-auto">
                        <table class="min-w-full text-sm text-left border border-gray-300">
                            <thead class="text-gray-700 bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border">#</th>
                                    <th class="px-4 py-2 border">Loại</th>
                                    <th class="px-4 py-2 border">Số tiền</th>
                                    <th class="px-4 py-2 border">Ghi chú</th>
                                    <th class="px-4 py-2 border">Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @endif

                                <tr>
                                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 capitalize border"> {{ $item->getTypeLabel() }}</td>
                                    <td class="px-4 py-2 text-right text-green-600 border">
                                        {{ number_format($item->amount, 0, ',', '.') }} đ
                                    </td>
                                    <td class="px-4 py-2 border">{{ $item->description ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item->created_at->format('H:i d/m/Y') }}</td>
                                </tr>

                                @if ($loop->last)
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @empty
                    <p class="text-gray-500">Chưa có giao dịch nào gần đây</p>
                    @endforelse
                </div>

            </div>

            {{-- Footer --}}
            <div class="mt-8 text-right">
                <button wire:click="closeModal"
                    class="px-5 py-2 text-white transition bg-gray-700 rounded-lg hover:bg-gray-800">
                    Đóng
                </button>
                <a href="{{ route('account.index') }}"
                    class="px-5 py-2 text-white transition bg-gray-700 rounded-lg hover:bg-gray-800">
                    Quay về
                </a>
            </div>
        </div>
    </div>

    {{-- JavaScript tab logic --}}
    <script>
        function switchTab(tab) {
            const allTabs = ['transfer', 'deposit', 'withdraw', 'history'];

            allTabs.forEach(id => {
                document.getElementById(`tab-${id}`).classList.add('hidden');
            });

            document.getElementById(`tab-${tab}`).classList.remove('hidden');

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('text-blue-600', 'border-blue-600');
                btn.classList.add('text-gray-600', 'border-transparent');
            });

            const activeBtn = [...document.querySelectorAll('.tab-btn')]
            .find(btn => btn.innerText.includes(tabLabel(tab)));
            if (activeBtn) {
                activeBtn.classList.remove('text-gray-600', 'border-transparent');
                activeBtn.classList.add('text-blue-600', 'border-blue-600');
            }
        }

        function tabLabel(tab) {
            return {
                transfer: 'Chuyển',
                deposit: 'Nạp',
                withdraw: 'Rút',
                history: 'Lịch'
            }[tab];
        }
    </script>
    <x-alert />
</x-app-layout>