<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\RolModel;
use App\Models\PermissionRoleModel;
use App\Models\PermissionModel;
use App\Models\Roller;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class RollerController extends Controller
{


  public function liste()
  {
    // $RolIzin = PermissionRoleModel::izinAl('Rol Düzenle', 7);
    // if (empty($RolIzin)) {
    //     abort(404);
    // }






    return view('roller.roller');
  }


  public function izinAl()
  {
    $izinler = DB::table('OFTV_ROL_IZINLER')
      ->select('slug')
      ->where('role_id', Auth::user()->role_id)
      ->get();

      return response()->json($izinler);
  }





  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'name',
      3 => 'created_at'
    ];


    $search = [];

    // if (empty($request->input('search.value'))) {
    $role = RolModel::all();
    // } else {
    //   $search = $request->input('search.value');

    //   $emirler = DB::table('OFTV_01_EMIRLERIS')
    //     ->where(function ($query) use ($istasyon) {
    //       $query->where('ISTTANIM',  'LIKE', "%{$istasyon}%"); // ISTKOD alanı için mutlak eşleşme
    //     })
    //     ->where(function ($query) use ($search) {
    //       $query->where('KOD', 'LIKE', "%{$search}%")
    //         ->orWhere('TANIM', 'LIKE', "%{$search}%")
    //         ->orWhere('ISTTANIM', 'LIKE', "%{$search}%")
    //         ->orWhere('MMLGRPKOD', 'LIKE', "%{$search}%")
    //         ->orWhere('DURUM', 'LIKE', "%{$search}%")
    //         ->orWhere('KAYITTARIH', 'LIKE', "%{$search}%");
    //     })
    //     ->orderBy('URETIMSIRA', 'asc')
    //     ->get();

    //   // $emirler = DB::table('OFTV_01_EMIRLERIS')
    //   //   ->where('KOD', 'LIKE', "%{$search}%")
    //   //   ->orWhere('TANIM', 'LIKE', "%{$search}%")
    //   //   ->orWhere('ISTTANIM', 'LIKE', "%{$search}%")
    //   //   ->orWhere('MMLGRPKOD', 'LIKE', "%{$search}%")
    //   //   ->orWhere('DURUM', 'LIKE', "%{$search}%")
    //   //   ->orWhere('KAYITTARIH', 'LIKE', "%{$search}%")
    //   //   ->orWhere('ISTKOD', 'LIKE', "%{$istasyon}%")
    //   //   ->orderBy('URETIMSIRA', 'asc')
    //   //   ->get();
    // }

    $data = [];

    if (!empty($role)) {
      // providing a dummy id instead of database ids
      $ids = 0;

      foreach ($role as $klt) {
        $nestedData['fake_id'] = ++$ids;
        $nestedData['id'] = $klt->id;
        $nestedData['name'] = $klt->name;
        $nestedData['created_at'] = $klt->created_at;


        $data[] = $nestedData;
      }
    }

    if ($data) {
      return response()->json([
        'draw' => intval($request->input('draw')),
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
   */
  public function create()
  {
    //
  }







  public function store(Request $request)
  {
    $veri = $request;


    $roleID = $veri->role_id1;
    $roleName = $veri->roleName;

    $role = RolModel::updateOrCreate(
      ['id' => $roleID],
      ['name' => $roleName]
    );

    PermissionRoleModel::where('role_id', '=', $roleID)->delete();
    foreach ($veri->permission_id as $p_id) {
      $save = new PermissionRoleModel;
      $save->permission_id = $p_id;
      $save->role_id = $roleID;
      $save->save();
    }

    return response()->json($veri);
  }







  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($role_id)
  {
    // Rolü al
    $kayitAl = RolModel::find($role_id);

    // İzinleri groupby sütununa göre gruplandır
    $permissions = PermissionModel::all()->groupBy('groupby');

    // Rol izinlerini al
    $rolIzinAl = PermissionRoleModel::where('role_id', $role_id)
      ->get(['permission_id']);

    // İzinleri uygun formatta düzenle
    $groupedPermissions = [];
    foreach ($permissions as $group => $perms) {
      $groupedPermissions[] = [
        'groupby' => $group,
        'permissions' => $perms->map(function ($perm) {
          return [
            'permission_id' => $perm->permission_id,
            'name' => $perm->name
          ];
        })->toArray()
      ];
    }

    // Sonuçları JSON formatında döndürelim
    return response()->json([
      'kayitAl' => $kayitAl,
      'permissions' => $groupedPermissions,
      'rolIzinAl' => $rolIzinAl
    ]);
  }



  public function update(Request $request, $id)
  {
    $roleName = $request->input('name');

    $role = RolModel::find($id);
    if ($role) {
      $role->name = $roleName;
      $role->save();

      return response()->json(['message' => 'Rol başarıyla güncellendi.']);
    }

    return response()->json(['message' => 'Rol bulunamadı.'], 404);
  }











  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $RolIzin = PermissionRoleModel::izinAl('Rol Sil', Auth::user()->role_id);
    if (empty($RolIzin)) {
      abort(404);
    }
    $save = RolModel::tekKayitAl($id);
    $save->delete();
    return redirect()->route('roller.roller')->with('success', "Rol başarılı bir şekilde silindi.");
  }
}
