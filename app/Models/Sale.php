<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    public function computeLabel()
    {
        if ($this->quantity == 1) {
            $this->label = $this->article->label;
        } else {
            $this->label = $this->quantity . 'x ' . $this->article->label;
        }
    }
}
