<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SfDates extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_date',
        'processed'
    ];
}
