<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kematian2019;

class Kematian2019Controller extends Controller
{
    public function index(){
        $bogor = Kematian2019::all();
        return view('kematian2019', compact('bogor'));
    }
}
