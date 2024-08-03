<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreedSynchronization extends Model
{
    use HasFactory;

    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class, 'breed_name', 'name');
    }
}
