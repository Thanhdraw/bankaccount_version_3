<?php
namespace App\Enums;


enum TransactionType: int
{
    case Deposit = 10;
    case Withdraw = 20;
    case TransferIn = 30;
    case TransferOut = 40;

    public function label(): string
    {
        return match ($this) {
            self::Deposit => 'Nạp tiền',
            self::Withdraw => 'Rút tiền',
            self::TransferIn => 'Nhận chuyển khoản',
            self::TransferOut => 'Chuyển khoản đi',
        };
    }
    public static function asSelectArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }

    public function isTransfer(): bool
    {
        return in_array($this, [self::TransferIn, self::TransferOut]);
    }
}