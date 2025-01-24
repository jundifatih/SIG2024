<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kematian2016;

class Kematian2016Controller extends Controller
{
    public function index(){
        $bogor = Kematian2016::all();
        return view('kematian2016', compact('bogor'));
    }
}
