<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kematian2020;

class Kematian2020Controller extends Controller
{
    public function index(){
        $bogor = Kematian2020::all();
        return view('kematian2020', compact('bogor'));
    }
}
