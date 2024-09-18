<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Roller;
use App\Models\PermissionRoleModel;
use App\Models\RolModel;
use App\Models\PermissionModel;

use Illuminate\Http\Request;

class RollerController_copy extends Controller
{
  public function liste()
  {
    // $RolIzin = PermissionRoleModel::izinAl('Roller', Auth::user()->role_id);
    // if (empty($RolIzin)) {
    //   abort(404);
    // }

    // $data['IzinEkle'] = PermissionRoleModel::izinAl('Rol Ekle', Auth::user()->role_id);
    // $data['IzinDuzenle'] = PermissionRoleModel::izinAl('Rol Düzenle', Auth::user()->role_id);
    // $data['IzinSil'] = PermissionRoleModel::izinAl('Rol Sil', Auth::user()->role_id);

    $datam = RolModel::all(); // Rol listesini almak için
    return view('roller.roller', compact('datam'));

    // $data['kayitAl'] = User::all(); //sanırım sadece kayıt yapılan veriler geliyor. all deseydik hepsi gelirdi.
    // $roles = RolModel::all(); // Kullanıcı tablosundaki tüm verileri çekin
    // return view('roller.liste', compact('roles'));
    // $data['kayitAl'] = RolModel::kayitAl();
    // return view('roller.roller', $data);
  }

  // public function ekle()
  // {
  //   $RolIzin = PermissionRoleModel::izinAl('Rol Ekle', Auth::user()->role_id);
  //   if (empty($RolIzin)) {
  //     abort(404);
  //   }

  //   $izinAl = PermissionModel::kayitAl();
  //   $data['izinAl'] = $izinAl;
  //   return view('roller.ekle', $data);
  // }

  // public function insert(Request $request)
  // {
  //   $RolIzin = PermissionRoleModel::getPermission('Add Role', Auth::user()->role_id);
  //   if (empty($RolIzin)) {
  //     abort(404);
  //   }
  //   $save = new RolModel;
  //   $save->name = $request->name;
  //   $save->save();

  //   PermissionRoleModel::guncellemeKayitEkle($request->permission_id, $save->id);
  //   // return redirect('/role')->with('success', "Role successfully created");
  //   return redirect()->route('roller.liste')->with('success', "Rol başarılı bir şekilde oluşturuldu.");
  // }

//   public function duzenle($id)
// {
//     $RolIzin = PermissionRoleModel::izinAl('Rol Düzenle', Auth::user()->role_id);
//     if (empty($RolIzin)) {
//         abort(404);
//     }

//     $data['kayitAl'] = RolModel::tekKayitAl($id);
//     $data['izinAl'] = PermissionModel::kayitAl();
//     $data['rolIzinAl'] = PermissionRoleModel::rolIzinAl($id);



//     return view('roller.duzenle', $data);
// }


  // public function guncelle($id, Request $request)
  // {
  //   $RolIzin = PermissionRoleModel::izinAl('Rol Düzenle', Auth::user()->role_id);
  //       if (empty($RolIzin)) {
  //           abort(404);
  //       }
  //   $save = RolModel::tekKayitAl($id);
  //   $save->name = $request->name;
  //   $save->save();

  //   PermissionRoleModel::guncellemeKayitEkle($request->permission_id, $save->id);

  //   return redirect()->route('roller.liste')->with('success', "Rol başarılı bir şekilde güncellendi.");
  // }

  // public function sil($id)
  // {
  //   $RolIzin = PermissionRoleModel::izinAl('Rol Sil', Auth::user()->role_id);
  //   if (empty($RolIzin)) {
  //       abort(404);
  //   }
  //   $save = RolModel::tekKayitAl($id);
  //   $save->delete();
  //   return redirect()->route('roller.liste')->with('success', "Rol başarılı bir şekilde silindi.");
  // }
}

