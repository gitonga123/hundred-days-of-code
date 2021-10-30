<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RRA extends Model
{
    protected $table = "rra-transit";
    protected $guarded = ['id'];
    use HasFactory;
}
