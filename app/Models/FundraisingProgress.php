<?php

namespace App\Models;

use Database\Factories\FundraisingProgressFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['amount_raised', 'confirmed_at'])]
class FundraisingProgress extends Model
{
    /** @use HasFactory<FundraisingProgressFactory> */
    use HasFactory;

    public const TARGET_AMOUNT = 35780;

    protected function casts(): array
    {
        return [
            'amount_raised' => 'decimal:2',
            'confirmed_at' => 'datetime',
        ];
    }
}
