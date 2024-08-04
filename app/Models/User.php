<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    public function parks(): MorphToMany
    {
        return $this->morphToMany(Park::class, 'parkable');
    }

    public function breeds(): MorphToMany
    {
        return $this->morphToMany(Breed::class, 'breedable');
    }
}
