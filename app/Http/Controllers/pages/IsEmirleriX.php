<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emir;
use Illuminate\Support\Facades\DB;

class IsEmirleri extends Controller
{
  public function index()
  {
    return view('content.pages.pages-isemirleri');
  }

  public function TestAl(){
    $emirler = DB::table('emirlers')->get();
    return response()->json($emirler);
  }
}