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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['title'];

    protected function title(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                return match ($attributes['gender']) {
                    0 => 'Cliente',
                    1 => 'Client',
                    default => 'Client·e',
                };
            }
        );
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function lastVisits(): HasMany
    {
        return $this->visits()->orderBy('visit_date', 'desc')->take(5);
    }
}
