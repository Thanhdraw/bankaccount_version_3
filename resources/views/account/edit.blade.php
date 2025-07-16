<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            ✏️ Sửa tài khoản
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl p-6 mx-auto bg-white shadow-md rounded-xl">
            <form method="POST" action="{{ route('account.update', $account->id) }}">
                @csrf
                @method('PUT')

                {{-- Tên chủ tài khoản --}}
                <div class="mb-4">
                    <label class="block font-medium text-gray-700">👤 Chủ tài khoản:</label>
                    <input type="text" name="account_holder_name"
                        value="{{ old('account_holder_name', $account->account_holder_name) }}"
                        class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                        required>
                </div>

                {{-- Số tài khoản (readonly) --}}
                <div class="mb-4">
                    <label class="block font-medium text-gray-700">🏦 Số tài khoản:</label>
                    <input type="text" value="{{ $account->account_number }}"
                        class="w-full mt-1 bg-gray-100 border-gray-300 rounded-lg shadow-sm" readonly>
                </div>

                {{-- Loại tài khoản --}}
                <div class="mb-4">
                    <label class="block font-medium text-gray-700">📂 Loại tài khoản:</label>
                    <select name="type" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                        @foreach ($types as $value => $label)
                        <option value="{{ $value }}" {{ old('type', $account->type->value ?? '') == $value ? 'selected'
                            : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Số dư --}}
                <div class="mb-4">
                    <label class="block font-medium text-gray-700">💰 Số dư:</label>
                    <input type="number" name="balance" min="0" value="{{ old('balance', $account->balance) }}"
                        class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                </div>

                {{-- Trạng thái --}}
                <div class="mb-6">
                    <label class="block font-medium text-gray-700">🔒 Trạng thái:</label>
                    <select name="status" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                        <option value="10" {{ old('status', $account->status->value) == 10 ? 'selected' : '' }}>
                            Hoạt động
                        </option>
                        <option value="20" {{ old('status', $account->status->value) == 20 ? 'selected' : '' }}>
                            Tạm khóa
                        </option>
                    </select>
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('account.index') }}"
                        class="px-4 py-2 text-white bg-gray-600 rounded hover:bg-gray-700">
                        ← Quay về
                    </a>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                        💾 Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>