<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\PermissionRoleModel;
use App\Models\RolModel;
use App\Models\Roller;
use App\Models\Kisiler;
use App\Models\PermissionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class KisiController extends Controller
{
  public function liste(Request $request)
  {


    $data['rolAl'] = RolModel::all(); // Rol listesini almak için
    
    // $data['kayitAl'] = User::all(); //sanırım sadece kayıt yapılan veriler geliyor. all deseydik hepsi gelirdi.
    return view('kisiler.liste', $data);
  }

  public function ekle()
  {
    $data['rolAl'] = RolModel::kayitAl();
    return view('kisiler.ekle', $data);
  }

  public function duzenle($id)
  {
    $data['kayitAl'] = Kisiler::tekKayitAl($id);
    $data['rolAl'] = RolModel::kayitAl();
    return view('kisiler.duzenle', $data);
  }

  public function insert(Request $request)
  {
    request()->validate([
      'email' => 'required|email|unique:users',
    ]);

    $kisi = new Kisiler;
    $kisi->name = trim($request->name);
    $kisi->email = trim($request->email);
    $kisi->password = Hash::make($request->password);
    $kisi->role = trim($request->role);
    $kisi->role_id = trim($request->role_id);
    $kisi->save();

    return redirect()->route('kisiler.liste')->with('success', "Kişi başarılı bir şekilde oluşturuldu.");
  }

  public function guncelle($id, Request $request)
  {

    $kisi = Kisiler::tekKayitAl($id);
    $kisi->name = trim($request->name);
    if (!empty($request->password)) {
      $kisi->password = Hash::make($request->password);
    }
    $kisi->role_id = trim($request->role_id);

    $kisi->save();

    // Rol adını almak için sorgu
    $rol_isim = DB::table('rol')->where('id', $request->role_id)->value('name');

    // Kullanıcıyı güncelleme
    DB::table('users')
      ->where('id', $id)
      ->update(['role' => $rol_isim]);



    return redirect()->route('kisiler.liste')->with('success', "Kişi başarılı bir şekilde güncellendi.");
  }

  public function sil($id)
  {
    $kisi = Kisiler::tekKayitAl($id);
    $kisi->delete();

    return redirect()->route('kisiler.liste')->with('success', "Kişi başarılı bir şekilde silindi.");
  }
}
