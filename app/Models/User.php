<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'location'
    ];

    public function parks(): MorphMany
    {
        return $this->morphToMany(Park::class, 'parkable');
    }

    public function breeds(): MorphMany
    {
        return $this->morphToMany(Breed::class, 'breedable');
    }
}
