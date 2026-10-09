<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_request_id',
        'promo_id',
        'promo_code',
        'invoice_number',
        'subtotal_amount',
        'discount_amount',
        'total_amount',
        'status',
        'issued_at',
        'paid_at',

        // Payment session
        'payment_method_pending',
        'payment_expires_at',
    ];

    protected $casts = [
        'subtotal_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'issued_at' => 'datetime',
        'paid_at' => 'datetime',

        // Payment session expiration
        'payment_expires_at' => 'datetime',
    ];

    public function repairRequest(): BelongsTo
    {
        return $this->belongsTo(RepairRequest::class);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}