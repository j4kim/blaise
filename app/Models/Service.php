<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'price' => 'real',
        ];
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
