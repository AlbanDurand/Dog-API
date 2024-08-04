<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Park extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'name'];

    public function breeds(): MorphMany
    {
        return $this->morphMany(Breed::class, 'breedable');
    }
}
