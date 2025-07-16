<?php

namespace App\Models;

use App\Enums\StatusAccount;
use App\Enums\TypeAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';

    protected $fillable = [
        'user_id',
        'account_number',
        'account_holder_name',
        'type',
        'status',
        'balance',
        'minimum_balance',
        'is_active',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'minimum_balance' => 'decimal:2',
        'is_active' => 'boolean',
        'type' => TypeAccount::class,
        'status' => \App\Enums\StatusAccount::class,
    ];
    protected static function booted()
    {
        static::creating(function ($account) {
            $account->account_number = self::generateAccountNumber();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public static function generateAccountNumber()
    {
        do {
            $generateNumber = str_pad(
                rand(0, 9999999999),
                10,
                '0',
                STR_PAD_LEFT
            );
        } while (
            DB::table('accounts')
                ->where('account_number', $generateNumber)
                ->exists()
        );

        return $generateNumber;
    }
    public function canWithdraw($amount): bool
    {
        return $amount > 0 &&
            ($this->balance - $amount) >= $this->minimum_balance;
    }

    public function getCurrentBalance()
    {
        $this->refresh();
        return $this->balance;
    }

    public function getFormattedBalance(): string
    {
        return number_format((float) $this->balance, 2, ',', '.') . ' ₫';
    }


}