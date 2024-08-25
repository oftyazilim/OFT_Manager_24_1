<?php

namespace App\Http\Controllers\satis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Str;

class SatisController extends Controller
{
  public function GetUser()
  {
    //dd('UserManagement');
    $siparisler =DB::connection('sqlSekerpinar')
    ->table('OFTV_MUS_SIPARISLERI')
    // ->where('durum', 'Açık')
    ->get();
    $siparisAd = $siparisler->count();
    $siparisKg = number_format($siparisler->sum('klnkg') / 1000, 0, ',', '.');

    $siparisAdYil = DB::connection('sqlSekerpinar')->table('OFTV_MUS_SIP_YIL')->get()->sum('topad');
    $siparisKgYil = number_format(DB::connection('sqlSekerpinar')->table('OFTV_MUS_SIP_YIL')->get()->sum('topkg'), 0, ',', '.');

    $siparisAdAy = DB::connection('sqlSekerpinar')->table('OFTV_MUS_SIP_AY')->get()->sum('topad');
    $siparisKgAy = number_format(DB::connection('sqlSekerpinar')->table('OFTV_MUS_SIP_AY')->get()->sum('topkg'), 0, ',', '.');

    $siparisAdGun = DB::connection('sqlSekerpinar')->table('OFTV_MUS_SIP_GUN')->get()->sum('topad');
    $siparisKgGun = number_format(DB::connection('sqlSekerpinar')->table('OFTV_MUS_SIP_GUN')->get()->sum('topkg'), 0, ',', '.');

    return view('content.satis.siparisler', [
      'toplamSiparisAd' => $siparisAd,
      'toplamSiparisKg' => $siparisKg,
      'toplamSiparisAdYil' => $siparisAdYil,
      'toplamSiparisKgYil' => $siparisKgYil,
      'toplamSiparisAdAy' => $siparisAdAy,
      'toplamSiparisKgAy' => $siparisKgAy,
      'toplamSiparisAdGun' => $siparisAdGun,
      'toplamSiparisKgGun' => $siparisKgGun,
    ]);
  }

  public function index(Request $request)
  {
    $columns = [
      1 => 'fisno',
      2 => 'musteri',
      3 => 'aciklama',
      4 => 'sprkg',
      5 => 'klnkg',
      6 => 'odemeplankodu',
      7 => 'tarih',
      8 => 'birim',
    ];

    $search = [];

    $totalData = DB::connection('sqlSekerpinar')
    ->table('OFTV_MUS_SIPARISLERI')->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $siparisler =DB::connection('sqlSekerpinar')
      ->table('OFTV_MUS_SIPARISLERI')->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $siparisler = DB::connection('sqlSekerpinar')
      ->table('OFTV_MUS_SIPARISLERI')->where('fisno', 'LIKE', "%{$search}%")
        ->orWhere('musteri', 'LIKE', "%{$search}%")
        ->orWhere('aciklama', 'LIKE', "%{$search}%")
        ->orWhere('tarih', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = DB::connection('sqlSekerpinar')
      ->table('OFTV_MUS_SIPARISLERI')->where('fisno', 'LIKE', "%{$search}%")
        ->orWhere('musteri', 'LIKE', "%{$search}%")
        ->orWhere('aciklama', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($siparisler)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($siparisler as $siparis) {
        $nestedData['fisno'] = $siparis->fisno;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['musteri'] = $siparis->musteri;
        $nestedData['aciklama'] = $siparis->aciklama;
        $nestedData['sprkg'] = number_format($siparis->sprkg, 2, ',','.');
        $nestedData['klnkg'] = number_format($siparis->klnkg, 2, ',','.');
        $nestedData['odemeplankodu'] = number_format($siparis->odemeplankodu, 0, ',','.');
        $nestedData['tarih'] = $siparis->tarih;
        $nestedData['birim'] = $siparis->birim;
        $nestedData['durum'] = number_format(($siparis->sprkg - $siparis->klnkg) / $siparis->sprkg * 100, 0, ',','.');

        $data[] = $nestedData;
      }
    }

    if ($data) {
      return response()->json([
        'draw' => intval($request->input('draw')),
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

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $userID = $request->id;

    if ($userID) {
      // update the value
      $users = User::updateOrCreate(
        ['id' => $userID],
        ['name' => $request->name, 'email' => $request->email]
      );

      // user updated
      return response()->json('Updated');
    } else {
      // create new one if email is unique
      $userEmail = User::where('email', $request->email)->first();

      if (empty($userEmail)) {
        $users = User::updateOrCreate(
          ['id' => $userID],
          ['name' => $request->name, 'email' => $request->email, 'password' => bcrypt(Str::random(10))]
        );

        // user created
        return response()->json('Created');
      } else {
        // user already exist
        return response()->json(['message' => "already exits"], 422);
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id): JsonResponse
  {
    $user = User::findOrFail($id);
    return response()->json($user);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {}

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $users = User::where('id', $id)->delete();
  }
}
