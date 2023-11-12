<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes
};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'currency_id',
        'balance',
        'deactivated_at',
    ];

    /**
     * Currency relation
     *
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

}
