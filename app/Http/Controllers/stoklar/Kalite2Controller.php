<?php

namespace App\Http\Controllers\stoklar;

use App\Http\Controllers\Controller;
use App\Models\Kalite2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Readline\Hoa\Console;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class Kalite2Controller extends Controller
{
  public function getKalite2()
  {
    $kalite2 = DB::connection('sqlAkyazi')
      ->table('mamulstok2')
      ->select('id', 'mamul', 'boy', 'pkno', 'nevi', 'adet', 'kg', 'hat', 'kantarkg', 'basildi', 'tarih', 'saat', 'operator', 'mamulkodu', 'vardiya', 'kalinlik')
      // ->orderBy('pkno')
      ->get();

    $mamuller = DB::connection('sqlAkyazi')
      ->table('mamuller')
      ->distinct('mamul')
      ->select('mamul', 'minkg')
      ->where('tip', 'Boru')
      ->orWhere('tip', 'Profil')
      ->orderBy('mamul')
      ->get();

    $hatlar = DB::connection('sqlAkyazi')
      ->table('paketno')
      ->select('hat')
      ->orderBy('hat')
      ->get();

    $nevi = DB::connection('sqlAkyazi')
      ->table('mamuller')
      ->distinct('nevi')
      ->select('nevi')
      ->where('tip', 'Boru')
      ->orWhere('tip', 'Profil')
      ->orderBy('nevi')
      ->get();

    $paketCount = $kalite2->count();
    $toplamKg = number_format($kalite2->sum('kantarkg'), 0, ',', '.');
    $toplamKgHr = DB::connection('sqlAkyazi')
      ->table('mamulstok2')
      ->where('nevi', 'HR')
      ->sum('kantarkg');

    $toplamKgDiger = DB::connection('sqlAkyazi')
      ->table('mamulstok2')
      ->whereNot('nevi', 'HR')
      ->sum('kantarkg');

    return view('content.stoklar.kalite2', [
      'toplamPaket' => $paketCount,
      'toplamKg' => $toplamKg,
      'toplamKgHr' => number_format($toplamKgHr, 0, ',', '.'),
      'toplamKgDiger' => number_format($toplamKgDiger, 0, ',', '.'),
      // 'kalite2' => $kalite2,
      // 'mamuller' => $mamuller,
      // 'hatlar' => $hatlar,
      // 'nevi' => $nevi
    ]);
  }









  public function getKalite2liste()
  {
    $mamullers = DB::connection('sqlAkyazi')
    ->table('mamuller')
    ->select('mamul')
    ->where('tip', 'Boru')
    ->orWhere('tip', 'Profil')
    ->distinct()
    ->get();
    return view('content.stoklar.kalite2liste', compact('mamullers'));
  }

  public function veriAl()
  {
    $kalite2 = Kalite2::all();

    $paketCount = $kalite2->count();
    $toplamKg = number_format($kalite2->sum('kantarkg'), 0, ',', '.');

    $toplamKgHr = Kalite2::where('nevi', 'HR')->sum('kantarkg');
    $toplamKgDiger = Kalite2::where('nevi', '!=', 'HR')->sum('kantarkg');

    return response()->json([
      $paketCount,
      $toplamKg,
      $toplamKgHr,
      $toplamKgDiger,
    ]);
  }

  public function index(Request $request)
  {
    $columns = [
      1 => 'mamul',
      2 => 'boy',
      3 => 'kantarkg',
      4 => 'adet',
      5 => 'kg',
      6 => 'nevi',
      7 => 'pkno',
      8 => 'hat',
      9 => 'tarih',
      10 => 'saat',
      11 => 'operator',
      12 => 'mamulkodu',
      13 => 'basildi',
      14 => 'id',
    ];

    $search = [];

    $toplamKg = Kalite2::all()->sum('kantarkg');

    $totalData = Kalite2::all()->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $kalite2 = Kalite2::offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $kalite2 = Kalite2::where('mamul', 'LIKE', "%{$search}%")
        ->orWhere('nevi', 'LIKE', "%{$search}%")
        ->orWhere('pkno', 'LIKE', "%{$search}%")
        ->orWhere('operator', 'LIKE', "%{$search}%")->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $toplamKg = Kalite2::where('mamul', 'LIKE', "%{$search}%")
        ->orWhere('boy', 'LIKE', "%{$search}%")
        ->orWhere('nevi', 'LIKE', "%{$search}%")->sum('kantarkg');

      $totalFiltered = Kalite2::where('mamul', 'LIKE', "%{$search}%")
        ->orWhere('boy', 'LIKE', "%{$search}%")
        ->orWhere('nevi', 'LIKE', "%{$search}%")->count();
    }

    $data = [];

    if (!empty($kalite2)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($kalite2 as $klt) {
        $nestedData['mamul'] = $klt->mamul;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['boy'] = $klt->boy;
        $nestedData['kantarkg'] = number_format($klt->kantarkg, 0, ',', '.');
        $nestedData['adet'] = number_format($klt->adet, 0, ',', '.');
        $nestedData['kg'] = number_format($klt->kg, 2, ',', '.');
        $nestedData['nevi'] = $klt->nevi;
        $nestedData['pkno'] = $klt->pkno;
        $nestedData['hat'] = $klt->hat;
        $nestedData['tarih'] = $klt->tarih;
        $nestedData['saat'] = $klt->saat;
        $nestedData['operator'] = $klt->operator;
        $nestedData['mamulkodu'] = $klt->mamulkodu;
        $nestedData['basildi'] = $klt->basildi;
        $nestedData['id'] = $klt->id;

        $data[] = $nestedData;
      }
    }

    if ($data) {
      return response()->json([
        'draw' => intval($request->input('draw')),
        'toplamKg' => number_format($toplamKg, 0, ',', '.'),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'code' => 200,
        'data' => $data,
      ]);
    } else {
      return response()->json([
        'message' => 'Internal Server Error',
        'code' => 500,
        'data' => [],
      ]);
    }
  }

  public function destroy($id)
  {
    $users = Kalite2::where('id', $id)->delete();
  }

  public function edit($id): JsonResponse
  {
    $kalite2 = Kalite2::distinct()->where('id', $id)
      ->get();
    return response()->json($kalite2);
  }

  public function store(Request $request)
  {
    $kayitID = $request->id;

    if ($kayitID) {
      $isBasildi = $request->has('basildi') ? 1 : 0;
      $mamuller = DB::connection('sqlAkyazi')
        ->table('mamuller')
        ->select('mamulkodu', 'minkg', 'kalinlik')
        ->where('mamul', $request->mamul)
        ->where('nevi', $request->nevi)
        ->first();
      $teorikKg = $request->adet * $mamuller->minkg * ($request->boy / 1000);

      $kayit = Kalite2::updateOrCreate(
        ['id' => $kayitID],
        [
          'mamul' => $request->mamul,
          'boy' => $request->boy,
          'nevi' => $request->nevi,
          'adet' => $request->adet,
          'kg' => $teorikKg,
          'hat' => $request->hat,
          'mamulkodu' => $mamuller->mamulkodu,
          'kantarkg' => $request->kantarkg,
          'kalinlik' => $mamuller->kalinlik,
          'basildi' => $isBasildi,
          'updated_at' => now(),
        ]
      );
      return response()->json('Updated');
    } else {
      $isBasildi = $request->has('basildi') ? 1 : 0;
      $currentDate = Carbon::now()->format('Y-m-d');
      $currentTime = Carbon::now()->format('H:i:s');
      $operatorName = Auth::user()->name;
      $paketno = $this->paketNoAl($request->hat);
      $mamuller = DB::connection('sqlAkyazi')
        ->table('mamuller')
        ->select('mamulkodu', 'minkg', 'kalinlik')
        ->where('mamul', $request->mamul)
        ->where('nevi', $request->nevi)
        ->first();
      $teorikKg = $request->adet * $mamuller->minkg * ($request->boy / 1000);

      $kayit = Kalite2::updateOrCreate(
        ['id' => $kayitID],
        [
          'mamul' => $request->mamul,
          'boy' => $request->boy,
          'pkno' => $paketno,
          'tarih' => $currentDate,
          'saat' => $currentTime,
          'hat' => $request->hat,
          'operator' => $operatorName,
          'nevi' => $request->nevi,
          'mamulkodu' => $mamuller->mamulkodu,
          'adet' => $request->adet,
          'kg' => $teorikKg,
          'kantarkg' => $request->kantarkg,
          'kalinlik' => $mamuller->kalinlik,
          'basildi' => $isBasildi,
          'created_at' => now(),
          'updated_at' => now(),
        ]
      );
      return response()->json('Created');
    }
  }



  public function getKalite2s()
  {
    $kalite2 = DB::connection('sqlSekerpinar')
      ->table('mamulstok2')
      ->select('id', 'mamul', 'boy', 'pkno', 'nevi', 'adet', 'kg', 'hat', 'kantarkg', 'basildi', 'tarih', 'saat', 'operator', 'mamulkodu', 'vardiya', 'kalinlik')
      ->get();

    $mamuller = DB::connection('sqlSekerpinar')
      ->table('mamuller')
      ->distinct('mamul')
      ->select('mamul', 'minkg')
      ->where('tip', 'Boru')
      ->orWhere('tip', 'Profil')
      ->orderBy('mamul')
      ->get();

    $hatlar = DB::connection('sqlSekerpinar')
      ->table('paketno')
      ->select('hat')
      ->orderBy('hat')
      ->get();

    $nevi = DB::connection('sqlSekerpinar')
      ->table('mamuller')
      ->distinct('nevi')
      ->select('nevi')
      ->where('tip', 'Boru')
      ->orWhere('tip', 'Profil')
      ->orderBy('nevi')
      ->get();

    $paketCount = $kalite2->count();
    $toplamKg = number_format($kalite2->sum('kantarkg'), 0, ',', '.');
    $toplamKgHr = DB::connection('sqlSekerpinar')
      ->table('mamulstok2')
      ->where('nevi', 'HR')
      ->sum('kantarkg');

    $toplamKgDiger = DB::connection('sqlSekerpinar')
      ->table('mamulstok2')
      ->whereNot('nevi', 'HR')
      ->sum('kantarkg');

    return view('content.stoklar.kalite2s', [
      'toplamPaket' => $paketCount,
      'toplamKg' => $toplamKg,
      'toplamKgHr' => number_format($toplamKgHr, 0, ',', '.'),
      'toplamKgDiger' => number_format($toplamKgDiger, 0, ',', '.'),
      'kalite2' => $kalite2,
      'mamuller' => $mamuller,
      'hatlar' => $hatlar,
      'nevi' => $nevi
    ]);
  }

  public function listeleKalite2()
  {

    // Veritabanından verileri çekin
    $kalite2 = DB::connection('sqlAkyazi')
      ->table('mamulstok2')
      ->select('id', 'mamul', 'boy', 'pkno', 'nevi', 'adet', 'kg', 'hat', 'kantarkg', 'basildi', 'tarih', 'saat', 'operator', 'mamulkodu', 'vardiya', 'kalinlik')
      ->get();

    // Verileri JSON formatında döndür
    return response()->json($kalite2);
  }

  public function listeleKalite2s()
  {

    // Veritabanından verileri çekin
    $kalite2 = DB::connection('sqlSekerpinar')
      ->table('mamulstok2')
      ->select('id', 'mamul', 'boy', 'pkno', 'nevi', 'adet', 'kg', 'hat', 'kantarkg', 'basildi', 'tarih', 'saat', 'operator', 'mamulkodu', 'vardiya', 'kalinlik')
      ->get();

    // Verileri JSON formatında döndür
    return response()->json($kalite2);
  }

  public function silKalite2(int $id)
  {
    // ID ile gelen kaydı sil
    $deleted = DB::connection('sqlAkyazi')
      ->table('mamulstok2')
      ->where('id', $id)
      ->delete();

    if ($deleted) {
      // Başarılı işlem yanıtı döndür
      return response()->json(['message' => 'Record deleted successfully'], 200);
    } else {
      // Hata durumunda yanıt döndür
      return response()->json(['message' => 'Record not found or could not be deleted'], 404);
    }
  }

  public function silKalite2s(int $id)
  {
    // ID ile gelen kaydı sil
    $deleted = DB::connection('sqlSekerpinar')
      ->table('mamulstok2')
      ->where('id', $id)
      ->delete();

    if ($deleted) {
      // Başarılı işlem yanıtı döndür
      return response()->json(['message' => 'Record deleted successfully'], 200);
    } else {
      // Hata durumunda yanıt döndür
      return response()->json(['message' => 'Record not found or could not be deleted'], 404);
    }
  }

  public function guncelleKalite2(Request $request, int $id)
  {

    // Doğrudan gelen verileri al
    $data = $request->only(['nevi', 'adet', 'mamul', 'boy', 'pkno', 'hat', 'operator', 'mamulkodu', 'basildi', 'kg', 'kantarkg']);

    // Veritabanında ilgili kaydı güncelle
    DB::connection('sqlAkyazi')
      ->table('mamulstok2')
      ->where('id', $id)
      ->update($data);

    return response()->json(['message' => 'Data updated successfully'], 200);
  }

  public function guncelleKalite2s(Request $request, int $id)
  {

    // Doğrudan gelen verileri al
    $data = $request->only(['nevi', 'adet', 'mamul', 'boy', 'pkno', 'hat', 'operator', 'mamulkodu', 'basildi', 'kg', 'kantarkg']);

    // Veritabanında ilgili kaydı güncelle
    DB::connection('sqlSekerpinar')
      ->table('mamulstok2')
      ->where('id', $id)
      ->update($data);

    return response()->json(['message' => 'Data updated successfully'], 200);
  }

  public function ekleKalite2s(Request $request)
  {

    // Veriyi doğrudan veritabanına ekle
    DB::connection('sqlSekerpinar')
      ->table('mamulstok2')
      ->insert([
        'mamul' => $request->mamul,
        'boy' => $request->boy,
        'pkno' => $request->pkno,
        'tarih' => $request->tarih,
        'saat' => $request->saat,
        'hat' => $request->hat,
        'operator' => $request->operator,
        'nevi' => $request->nevi,
        'mamulkodu' => $request->mamulkodu,
        'adet' => $request->adet,
        'kg' => $request->kg,
        'kantarkg' => $request->kantarkg,
        'kalinlik' => $request->kalinlik,
        'basildi' => $request->basildi,
        'created_at' => now(),
        'updated_at' => now(),
      ]);

    $kalite2 = DB::connection('sqlSekerpinar')
      ->table('mamulstok2')
      ->select('id', 'mamul', 'boy', 'pkno', 'nevi', 'adet', 'kg', 'hat', 'kantarkg', 'basildi', 'tarih', 'saat', 'operator', 'mamulkodu', 'vardiya', 'kalinlik')
      ->orderBy('pkno')
      ->get();

    // Başarılı işlem yanıtı döndür
    return response()->json(['message' => 'Data inserted successfully', 'kalite2' => $kalite2], 200);
  }
  public function ekleKalite2(Request $request)
  {

    // Veriyi doğrudan veritabanına ekle
    DB::connection('sqlAkyazi')
      ->table('mamulstok2')
      ->insert([
        'mamul' => $request->mamul,
        'boy' => $request->boy,
        'pkno' => $request->pkno,
        'tarih' => $request->tarih,
        'saat' => $request->saat,
        'hat' => $request->hat,
        'operator' => $request->operator,
        'nevi' => $request->nevi,
        'mamulkodu' => $request->mamulkodu,
        'adet' => $request->adet,
        'kg' => $request->kg,
        'kantarkg' => $request->kantarkg,
        'kalinlik' => $request->kalinlik,
        'basildi' => $request->basildi,
        'created_at' => now(),
        'updated_at' => now(),
      ]);

    $kalite2 = DB::connection('sqlAkyazi')
      ->table('mamulstok2')
      ->select('id', 'mamul', 'boy', 'pkno', 'nevi', 'adet', 'kg', 'hat', 'kantarkg', 'basildi', 'tarih', 'saat', 'operator', 'mamulkodu', 'vardiya', 'kalinlik')
      ->orderBy('pkno')
      ->get();

    // Başarılı işlem yanıtı döndür
    return response()->json(['message' => 'Data inserted successfully', 'kalite2' => $kalite2], 200);
  }

  public function paketNoAls(string $hat)
  {
    $pkno = 1;
    $tarih = now();


    if (substr($hat, 1, 1) === "A") {
      switch (substr($hat, 3, 1)) {
        case "1":
          $pkno = 1001;
          break;
        case "2":
          $pkno = 2001;
          break;
        case "3":
          $pkno = 3001;
          break;
        case "4":
          $pkno = 4001;
          break;
      }
    } else {
      switch (substr($hat, 3, 1)) {
        case "1":
          $pkno = 5001;
          break;
        case "2":
          $pkno = 6001;
          break;
        case "3":
          $pkno = 7001;
          break;
        case "4":
          $pkno = 8001;
          break;
      }
    }


    // Veriyi güncelle ve sonra çek
    DB::connection('sqlSekerpinar')->table('paketno')
      ->where('hat', $hat)
      ->increment('paketno', 1);

    $paketNoData = DB::connection('sqlSekerpinar')->table('paketno')
      ->where('hat', $hat)
      ->select('tarih', 'paketno')
      ->first();

    if ($paketNoData) {
      $tarih = Carbon::parse($paketNoData->tarih);
      $pkno = $paketNoData->paketno;
    }

    if (strtotime($tarih) < strtotime(Carbon::create(Carbon::now()->year, Carbon::now()->month, Carbon::now()->day))) {
      $tarih = Carbon::now();
      if (substr($hat, 1, 1) === "A") {
        switch (substr($hat, 3, 1)) {
          case "1":
            $pkno = 1001;
            break;
          case "2":
            $pkno = 2001;
            break;
          case "3":
            $pkno = 3001;
            break;
          case "4":
            $pkno = 4001;
            break;
        }
      } else {
        switch (substr($hat, 3, 1)) {
          case "1":
            $pkno = 5001;
            break;
          case "2":
            $pkno = 6001;
            break;
          case "3":
            $pkno = 7001;
            break;
          case "4":
            $pkno = 8001;
            break;
        }
      }

      DB::connection('sqlSekerpinar')->table('paketno')
        ->where('hat', $hat)
        ->update([
          'tarih' => $tarih,
          'paketno' => $pkno
        ]);
    }

    $paketno = sprintf('%02d %02d %02d %04d', $tarih->year % 100, $tarih->month, $tarih->day, $pkno);

    return $paketno;
  }

  public function paketNoAl(string $hat)
  {
    $pkno = 1;
    $tarih = now();


    if (substr($hat, 1, 1) === "A") {
      switch (substr($hat, 3, 1)) {
        case "1":
          $pkno = 1001;
          break;
        case "2":
          $pkno = 2001;
          break;
        case "3":
          $pkno = 3001;
          break;
        case "4":
          $pkno = 4001;
          break;
      }
    } else {
      switch (substr($hat, 3, 1)) {
        case "1":
          $pkno = 5001;
          break;
        case "2":
          $pkno = 6001;
          break;
        case "3":
          $pkno = 7001;
          break;
        case "4":
          $pkno = 8001;
          break;
      }
    }


    // Veriyi güncelle ve sonra çek
    DB::connection('sqlAkyazi')->table('paketno')
      ->where('hat', $hat)
      ->increment('paketno', 1);

    $paketNoData = DB::connection('sqlAkyazi')->table('paketno')
      ->where('hat', $hat)
      ->select('tarih', 'paketno')
      ->first();

    if ($paketNoData) {
      $tarih = Carbon::parse($paketNoData->tarih);
      $pkno = $paketNoData->paketno;
    }

    if (strtotime($tarih) < strtotime(Carbon::create(Carbon::now()->year, Carbon::now()->month, Carbon::now()->day))) {
      $tarih = Carbon::now();
      if (substr($hat, 1, 1) === "A") {
        switch (substr($hat, 3, 1)) {
          case "1":
            $pkno = 1001;
            break;
          case "2":
            $pkno = 2001;
            break;
          case "3":
            $pkno = 3001;
            break;
          case "4":
            $pkno = 4001;
            break;
        }
      } else {
        switch (substr($hat, 3, 1)) {
          case "1":
            $pkno = 5001;
            break;
          case "2":
            $pkno = 6001;
            break;
          case "3":
            $pkno = 7001;
            break;
          case "4":
            $pkno = 8001;
            break;
        }
      }

      DB::connection('sqlAkyazi')->table('paketno')
        ->where('hat', $hat)
        ->update([
          'tarih' => $tarih,
          'paketno' => $pkno
        ]);
    }

    $paketno = sprintf('%02d %02d %02d %04d', $tarih->year % 100, $tarih->month, $tarih->day, $pkno);

    return $paketno;
  }

  public function getMamulKodus(Request $request)
  {
    $mamulkodu = DB::connection('sqlSekerpinar')
      ->table('mamuller')
      ->select('mamulkodu', 'minkg', 'kalinlik')
      ->where('mamul', $request->m)
      ->where('nevi', $request->n)
      ->first();

    return $mamulkodu;
  }

  public function getMamulKodu(Request $request)
  {
    $mamulkodu = DB::connection('sqlAkyazi')
      ->table('mamuller')
      ->select('mamulkodu', 'minkg', 'kalinlik')
      ->where('mamul', $request->m)
      ->where('nevi', $request->n)
      ->first();

    return $mamulkodu;
  }
}
