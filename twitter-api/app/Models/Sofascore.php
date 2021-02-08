<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sofascore extends Model
{
    use HasFactory;
    protected $fillable = [
        'competition',
        'player_1',
        'player_2',
        'home_odd',
        'away_odd',
        'expected_value_home',
        'actual_value_home',
        'expected_value_away',
        'actual_value_away',
        'result'
    ];
}
