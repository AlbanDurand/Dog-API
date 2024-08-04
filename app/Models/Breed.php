<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'breedable');
    }

    public function parks(): MorphToMany
    {
        return $this->morphedByMany(Park::class, 'breedable');
    }
}
