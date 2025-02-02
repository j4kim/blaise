<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visit extends Model
{
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    protected function total(): Attribute
    {
        return new Attribute(
            get: fn() => $this->sales->sum('price_charged'),
        );
    }
}
