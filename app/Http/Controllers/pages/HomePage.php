<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Uretim;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomePage extends Controller
{
  public function index()
  {
    //$tonaj = $this->veriAl();

    // $mamullers = DB::connection('sqlAkyazi')
    //   ->table('mamuller')
    //   ->select('mamul')
    //   ->where('tip', 'Boru')
    //   ->orWhere('tip', 'Profil')
    //   ->distinct()
    //   ->get();

    // $nevi = DB::connection('sqlAkyazi')
    //   ->table('mamuller')
    //   ->select('nevi')
    //   ->where('tip', 'Boru')
    //   ->orWhere('tip', 'Profil')
    //   ->distinct()
    //   ->get();

    // $hatlar = DB::connection('sqlAkyazi')
    //   ->table('caldurum')
    //   ->select('hat')
    //   ->distinct()
    //   ->get();

    return view('content.pages.pages-home');
  }

  public function veriAl()
  {
    $tonaj = number_format(Uretim:: //where('FABRIKA', 'Akyazı')->
      where('TARIH', '>', Carbon::now()->startOfMonth())
      ->get()->sum('KG') / 1000, 0, ",", ".");
    // $kalite2 = Kalite2::where('silindi', false)->get();

    // $paketCount = $kalite2->count();
    // $toplamKg = number_format($kalite2->sum('kantarkg'), 0, ',', '.');

    // $toplamKgHr = number_format($kalite2->where('silindi', false)->where('nevi', '==', 'HR')->sum('kantarkg'), 0, ',', '.');
    // $toplamKgDiger = number_format($kalite2->where('silindi', false)->where('nevi', '!=', 'HR')->sum('kantarkg'), 0, ',', '.');

    return response()->json([
      $tonaj
    ]);
  }
}
