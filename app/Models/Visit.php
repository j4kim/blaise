<?php

namespace App\Models;

use App\Mail\TicketMail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;

class Visit extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'billed' => 'real',
            'card_payment' => 'real',
            'cash_payment' => 'real',
            'twint_payment' => 'real',
            'voucher_payment' => 'real',
            'tip' => 'real',
            'rounding' => 'real',
            'visit_date' => 'datetime',
        ];
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class)->withTrashed();
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function technicalSheet(): HasOne
    {
        return $this->hasOne(TechnicalSheet::class)->withTrashed();
    }

    protected function subtotal(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->sales->sum('price_charged');
            },
        );
    }

    protected function total(): Attribute
    {
        return new Attribute(
            get: function () {
                $sum = $this->subtotal;
                if ($this->rounding) {
                    $sum = $sum + $this->rounding;
                }
                if ($this->tip) {
                    $sum = $sum + $this->tip;
                }
                return $sum;
            },
        );
    }

    public function sendEmail()
    {
        Mail::to($this->client)->send(new TicketMail($this));
    }
}
