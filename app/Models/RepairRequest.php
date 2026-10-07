<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RepairRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'user_id',
        'service_id',
        'preferred_date',
        'issue',
        'status',
        'estimated_cost',
        'final_cost',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function repairHistories(): HasMany
    {
        return $this->hasMany(RepairHistory::class);
    }

    public function invoice(): HasOne
    {
    return $this->hasOne(Invoice::class);
    }

    public function service(): BelongsTo 
    { 
    return $this->belongsTo(Service::class); 
    }

    protected $casts = [
        'preferred_date' => 'date',
    ];
}