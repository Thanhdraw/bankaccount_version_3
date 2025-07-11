<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'transaction_id',
        'account_id',
        'transaction_type',
        'amount',
        'balance_before',
        'balance_after',
        'description',
        'reference_account_id',
        'reference_number',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'transaction_type' => TransactionType::class
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function referenceAccount()
    {
        return $this->belongsTo(Account::class, 'reference_account_id');
    }

    public function scopeForAccount(Builder $query, $accountId): Builder
    {
        return $query->where('account_id', $accountId);
    }

    public function scopeByType(Builder $query, TransactionType $type): Builder
    {
        return $query->where('transaction_type', $type->value);
    }

    public function scopeByDateRange(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeRecent(Builder $query, $limit = 10): Builder
    {
        return $query->orderByDesc('created_at')->limit($limit);
    }
    public static function generateTransactionId(): string
    {
        do {
            $id = 'TXN' . now()->format('YmdHis') . rand(1000, 9999);
        } while (self::where('transaction_id', $id)->exists());

        return $id;
    }

    public function getFormattedAmount(): string
    {
        return number_format((float) $this->amount, 2, ',', '.') . ' ₫';
    }
    public function getTypeLabel(): string
    {
        return $this->transaction_type->label();
    }

    public function isTransfer(): bool
    {
        return $this->transaction_type->isTransfer();
    }


    protected static function booted(): void
    {
        static::creating(function ($transaction) {
            $transaction->transaction_id = self::generateTransactionId();

            // Lấy số dư trước nếu chưa có
            if (is_null($transaction->balance_before)) {
                $transaction->balance_before = $transaction->account->balance ?? 0;
            }

            $transaction->balance_after = match ($transaction->transaction_type) {
                TransactionType::Deposit,
                TransactionType::TransferIn => $transaction->balance_before + $transaction->amount,

                TransactionType::Withdraw,
                TransactionType::TransferOut => $transaction->balance_before - $transaction->amount,
            };
        });

        static::created(function ($transaction) {
            $account = $transaction->account;

            $account->balance = $transaction->balance_after;
            $account->save();
        });
    }

}