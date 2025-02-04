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

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
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
