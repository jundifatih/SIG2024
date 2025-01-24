<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kematian2017;

class Kematian2017Controller extends Controller
{
    public function index(){
        $bogor = Kematian2017::all();
        return view('kematian2017', compact('bogor'));
    }
}
