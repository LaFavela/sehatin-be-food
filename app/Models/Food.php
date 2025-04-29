<?php

namespace App\Models;

use App\Enum\Activity;
use App\Enum\Gender;
use App\Enum\Goal;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasFactory, SoftDeletes, HasTimestamps;

    protected $connection = 'mongodb';

    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'calories',
        'carb',
        'protein',
        'fat'
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'calories' => 'double',
            'carb' => 'double',
            'protein' => 'double',
            'fat' => 'double',
        ];
    }
}
