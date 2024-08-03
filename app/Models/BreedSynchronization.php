<?php

namespace App\Models;

use App\Domain\Breed\BreedId;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreedSynchronization extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'breedSynchronizations';
    protected $fillable = ['breed_name', 'synchronized_at'];

    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class, 'breed_name', 'name');
    }
}
