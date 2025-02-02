<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
