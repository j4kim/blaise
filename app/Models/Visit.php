<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'billed' => 'real',
        ];
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class)->withTrashed();
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
                if ($this->rounding) {
                    $sum = $sum + $this->rounding;
                }
                return round($sum, 2);
            },
        );
    }
}
