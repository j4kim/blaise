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

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class)->whereNotNull('billed');
    }

    public function lastVisits(): HasMany
    {
        return $this->visits()->orderBy('visit_date', 'desc')->take(5);
    }

    public function title(): Attribute
    {
        return new Attribute(
            get: fn() =>
            match ($this->gender) {
                0 => 'Cliente',
                1 => 'Client',
                default => 'Client·e',
            }
        );
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
        return $this->visits()->with('sales')->whereNull('billed')->first()?->append('subtotal');
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
