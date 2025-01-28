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
}
