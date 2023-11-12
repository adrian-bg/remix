<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionType extends Model
{
    use HasFactory;

    public const DEPOSIT_TYPE = 1;
    public const WITHDRAWAL_TYPE = 2;

    public const PAYMENT_TYPE = [
        self::DEPOSIT_TYPE => 'credit',
        self::WITHDRAWAL_TYPE => 'debit',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
    ];

}
