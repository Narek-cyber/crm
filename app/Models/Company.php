<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'tariff_id'
    ];

    /**
     * @return BelongsTo
     */
    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
