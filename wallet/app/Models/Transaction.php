<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_id',
        'card_id',
        'transaction_type_id',
        'transaction_status_id',
        'amount',
    ];

    /**
     * Account relation
     *
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * TransactionType relation
     *
     * @return BelongsTo
     */
    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    /**
     * TransactionStatus relation
     *
     * @return BelongsTo
     */
    public function transactionStatus(): BelongsTo
    {
        return $this->belongsTo(TransactionStatus::class);
    }
}
