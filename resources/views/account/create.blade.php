<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Tạo tài khoản mới
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl p-6 mx-auto bg-white rounded-lg shadow dark:bg-gray-800">
            <form action="{{ route('account.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="account_holder_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Chủ tài khoản
                    </label>
                    <input type="text" id="account_holder_name" name="account_holder_name" required
                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                </div>

                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Loại tài khoản
                    </label>
                    <select id="type" name="type" required
                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        @foreach ($types as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="balance" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Số dư ban đầu
                    </label>
                    <input type="number" id="balance" name="balance" min="0" required
                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="px-5 py-2 font-medium text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                        Tạo tài khoản
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>