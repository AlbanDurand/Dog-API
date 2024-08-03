<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Breed extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'name';
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
