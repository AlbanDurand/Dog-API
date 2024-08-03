<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreedSummaryListSynchronization extends Model
{
    use HasFactory;

    protected $table = 'breedSummaryListSynchronizations';
    protected $fillable = ['synchronized_at'];
    public $timestamps = false;
}
