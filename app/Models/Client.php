<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function allVisits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function visits(): HasMany
    {
        return $this->allVisits()->whereNotNull('billed');
    }

    public function lastVisits(): HasMany
    {
        return $this->visits()->orderBy('visit_date', 'desc')->take(5);
    }

    public function technicalSheets(): HasMany
    {
        return $this->hasMany(TechnicalSheet::class);
    }

    public function lastTechnicalSheets(): HasMany
    {
        return $this->technicalSheets()->orderBy('created_at', 'desc')->take(5);
    }

    protected function name(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->first_name . ' ' . $this->last_name;
            },
        );
    }

    public function getCurrentVisit(): ?Visit
    {
        return $this->allVisits()
            ->with('sales', 'technicalSheet')
            ->whereNull('billed')
            ->first()
            ?->append('subtotal');
    }

    public function scopeSearch(Builder $builder, string $query)
    {
        $words = explode(" ", $query);
        foreach ($words as $word) {
            $builder->where(
                function (Builder $qb) use ($word) {
                    $qb->where("first_name", "like", "$word%")
                        ->orWhere("last_name", "like", "$word%");
                }
            );
        }
    }
}
