<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visit extends Model
{
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function getTotal(): float
    {
        return $this->sales->sum('price_charged');
    }
}
