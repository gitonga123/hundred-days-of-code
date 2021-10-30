<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quarterly extends Model
{
    protected $table = "quartely_t1";
    protected $guarded = ['id'];
    use HasFactory;
}
