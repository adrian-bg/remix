<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    use HasFactory;

    public const TRANSACTION_STATUS_COMPLETED = 1;
    public const TRANSACTION_STATUS_PENDING = 2;
    public const TRANSACTION_STATUS_CANCELED = 3;
    public const TRANSACTION_STATUS_FAILED = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
    ];

    /**
     * The table's name
     *
     * @var string
     */
    protected $table = 'transaction_statuses';
}
