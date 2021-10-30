<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RRA;

class MigrateController extends Controller
{
    public function index()
    {
        $records = RRA::where('update_id', 0)->take(10);
        foreach ($records as $value) {
            dd($value->ENTRY);
        }
    }
}
