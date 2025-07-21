<?php

namespace App\Enums;

enum StatusAccount: int
{

    case Open = 10;
    case Block = 20;

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Hoạt động',
            self::Block => 'Khoá',

        };
    }
    public function color(): string
    {
        return match ($this) {
            self::Open => 'text-green-600',
            self::Block => 'text-red-600',
        };
    }

    public static function asSelectArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }


}