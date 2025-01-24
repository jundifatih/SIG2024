<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KotaBogor;

class KotaBogorController extends Controller
{
    public function index(){
        $kotabogor = KotaBogor::all();
        return view('kotabogor', compact('kotabogor'));
    }
}
