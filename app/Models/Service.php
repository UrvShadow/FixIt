<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'starting_price',
        'is_active',
    ];

    protected $casts = [
        'starting_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}