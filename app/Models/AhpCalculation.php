<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AhpCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'comparison_matrix',
        'normalized_matrix',
        'priority_vector',
        'lambda_max',
        'consistency_index',
        'consistency_ratio',
        'is_consistent',
        'calculated_at'
    ];

    protected $casts = [
        'comparison_matrix' => 'array',
        'normalized_matrix' => 'array',
        'priority_vector' => 'array',
        'lambda_max' => 'decimal:6',
        'consistency_index' => 'decimal:6',
        'consistency_ratio' => 'decimal:6',
        'is_consistent' => 'boolean',
        'calculated_at' => 'datetime',
    ];
}
