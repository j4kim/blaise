<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visit extends Model
{
    protected function casts(): array
    {
        return [
            'billed' => 'real',
        ];
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    protected function total(): Attribute
    {
        return new Attribute(
            get: function () {
                $sum = $this->sales->sum('price_charged');
                if ($this->discount) {
                    $sum = $sum - ($this->discount * $sum);
                }
                if ($this->voucher_payment) {
                    $sum = $sum - $this->voucher_payment;
                }
                return round($sum, 2);
            },
        );
    }
}
