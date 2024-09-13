<?php

namespace App\Http\Controllers\stoklar;

use App\Http\Controllers\Controller;
use App\Models\Kalite2;
use Illuminate\Http\Request;

class StokSayimController extends Controller
{

  public function sayimYap()
  {
    return view('content.stoklar.sayimOkuma');
  }

  public function sayim(Request $request)
  {
    $barkod = $request->input('barkod');
    $mesaj = $barkod;

    // Barkodun veritabanında olup olmadığını kontrol et
    $stok = Kalite2::where('pkno', $barkod)->first();

    if ($stok) {
      // Sayıldı alanını güncelle
      $stok->sayildi = 1;
      $stok->save();
    }

    // Özet bilgileri hesapla
    $toplamSayilanAdet = Kalite2::where('sayildi', 1)->count();
    $sayilmayanStokAdeti = Kalite2::where('sayildi', 0)->count();

    return response()->json([
      'mesaj' => $mesaj,
      'toplamSayilanAdet' => $toplamSayilanAdet,
      'sayilmayanStokAdeti' => $sayilmayanStokAdeti,
    ]);
  }
}
