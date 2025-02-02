<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function lastVisits(): HasMany
    {
        return $this->visits()->whereNotNull('billed')->orderBy('visit_date', 'desc')->take(5);
    }

    public function getTitle(): string
    {
        return match ($this->gender) {
            0 => 'Cliente',
            1 => 'Client',
            default => 'Client·e',
        };
    }

    public function getCurrentVisit(): ?Visit
    {
        return $this->visits()->with('sales')->whereNull('billed')->first()?->append('total');
    }
}
