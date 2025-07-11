<div class="max-w-xl mx-auto p-4">
    <form wire:submit.prevent="createAccount">
        <div class="mb-4">
            <label class="block">Tên người sở hữu tài khoản</label>
            <input type="text" wire:model="account_holder_name" class="w-full border rounded p-2">
            @error('account_holder_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block">Loại tài khoản</label>
            <select wire:model="type" class="w-full border rounded p-2">
                <option value="">-- Chọn loại --</option>
                <option value="10">Tiết kiệm</option>
                <option value="20">Thanh toán</option>
            </select>
            @error('type')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block">Số tiền nạp ban đầu</label>
            <input type="number" wire:model="initial_deposit" class="w-full border rounded p-2">
            @error('initial_deposit')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tạo tài khoản</button>

        @if (session()->has('success'))
            <div class="mt-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="mt-4 text-red-600">{{ session('error') }}</div>
        @endif
    </form>
    @stack('scripts')
</div>

