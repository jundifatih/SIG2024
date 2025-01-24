<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kematian2018;

class Kematian2018Controller extends Controller
{
    public function index(){
        $bogor = Kematian2018::all();
        return view('kematian2018', compact('bogor'));
    }
}
