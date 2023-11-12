<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes
};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'card_type_id',
        'card_provider_id',
        'names',
        'number',
        'cvv',
        'expire_at',
    ];

    /**
     * CardType relation
     *
     * @return BelongsTo
     */
    public function cardType(): BelongsTo
    {
        return $this->belongsTo(CardType::class);
    }

    /**
     * CardProvider relation
     *
     * @return BelongsTo
     */
    public function cardProvider(): BelongsTo
    {
        return $this->belongsTo(CardProvider::class);
    }
}
