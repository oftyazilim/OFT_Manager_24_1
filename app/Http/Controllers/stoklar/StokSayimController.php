<?php

namespace App\Http\Controllers\stoklar;

use App\Http\Controllers\Controller;
use App\Models\Kalite2;
use App\Models\Kalite2s;
use Illuminate\Http\Request;

class StokSayimController extends Controller
{

  public function sayimYap()
  {
    return view('content.stoklar.sayimOkuma');
  }

  public function sayimYaps()
  {
    return view('content.stoklar.sayimOkumas');
  }

  public function sayim(Request $request)
  {
    $okuma = $request->input('okuma');
    $sonuc = false;

    if ($okuma) {
      $barkod = $request->input('barkod');
      if ($barkod != '') {
        $mesaj = $barkod;

        // Barkodun veritabanında olup olmadığını kontrol et
        $stok = Kalite2::where('pkno', $barkod)->first();

        if ($stok) {

          if ($stok->sayildi) {
            $mesaj = "$barkod zaten sayım yapılmış.";
          } else {
            // Sayıldı alanını güncelle
            $stok->sayildi = 1;
            $stok->save();
            $mesaj = $barkod;
            $sonuc = true;
          }
        } else {
          $mesaj = 'Stok Bulunamadı (' . $barkod . ')';
        }
        return response()->json([
          'mesaj' => $mesaj,
          'sonuc' => $sonuc,
        ]);
      }
    } else {
      // Özet bilgileri hesapla
      $stok = Kalite2::where('silindi', false)
      ->where('sevk_edildi', false)
      ->get();

      $toplamSayilanAdet = $stok->where('sayildi', 1)->count();
      $sayilmayanStokAdeti = $stok->where('sayildi', 0)->count();

      return response()->json([
        'toplamSayilanAdet' => $toplamSayilanAdet,
        'sayilmayanStokAdeti' => $sayilmayanStokAdeti,
      ]);
    }
  }

  public function sayims(Request $request)
  {
    $okuma = $request->input('okuma');
    $sonuc = false;

    if ($okuma) {
      $barkod = $request->input('barkod');
      if ($barkod != '') {
        $mesaj = $barkod;

        // Barkodun veritabanında olup olmadığını kontrol et
        $stok = Kalite2s::where('pkno', $barkod)->first();

        if ($stok) {

          if ($stok->sayildi) {
            $mesaj = "$barkod zaten sayım yapılmış.";
          } else {
            // Sayıldı alanını güncelle
            $stok->sayildi = 1;
            $stok->save();
            $mesaj = $barkod;
            $sonuc = true;
          }
        } else {
          $mesaj = 'Stok Bulunamadı (' . $barkod . ')';
        }
        return response()->json([
          'mesaj' => $mesaj,
          'sonuc' => $sonuc,
        ]);
      }
    } else {
      // Özet bilgileri hesapla
      $stok = Kalite2s::where('silindi', false)
      ->where('sevk_edildi', false)
      ->get();

      $toplamSayilanAdet = $stok->where('sayildi', 1)->count();
      $sayilmayanStokAdeti = $stok->where('sayildi', 0)->count();

      return response()->json([
        'toplamSayilanAdet' => $toplamSayilanAdet,
        'sayilmayanStokAdeti' => $sayilmayanStokAdeti,
      ]);
    }
  }

  public function resetSayildi(){
    Kalite2::where('silindi', false)
      ->where('sevk_edildi', false)
      ->update(['sayildi' => 0]);

      return response()->json(['message' => 'Stok sayildi alanları sıfırlandı.'], 200);
    }

    public function resetSayildis(){
    Kalite2::where('silindi', false)
      ->where('sevk_edildi', false)
      ->update(['sayildi' => 0]);

      return response()->json(['message' => 'Stok sayildi alanları sıfırlandı.'], 200);
    }
}
