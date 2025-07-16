<?php

namespace App\Enums;

enum TypeAccount: int
{

    case Saving = 10;
    case Checking = 20;
    case Business = 30;
    case Student = 40;

    public function label(): string
    {
        return match ($this) {
            self::Saving => 'Tiết kiệm',
            self::Checking => 'Thanh toán',
            self::Business => 'Doanh nghiệp',
            self::Student => 'Sinh viên',
        };
    }
    public static function asSelectArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }


}