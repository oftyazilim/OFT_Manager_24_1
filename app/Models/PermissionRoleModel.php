<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRoleModel extends Model
{
  use HasFactory;

  protected $table = 'permission_role';

  static public function guncellemeKayitEkle($permission_ids, $role_id)
  {
    PermissionRoleModel::where('role_id', '=', $role_id)->delete();
    foreach ($permission_ids as $permission_id) {
      $save = new PermissionRoleModel;
      $save->permission_id = $permission_id;
      $save->role_id = $role_id;
      $save->save();
    }
  }
  static public function rolIzinAl($role_id)
  {
    return PermissionRoleModel::where('role_id', '=', $role_id)->get();
  }

  static public function izinAl($slug, $role_id)
  {
    $result = PermissionRoleModel::select('permission_role.id')
      ->join('permission', 'permission.permission_id', '=', 'permission_role.permission_id')
      ->where('permission_role.role_id', '=', $role_id)
      ->where('permission.slug', '=', $slug)
      ->count();

    return $result;

     // Permission ve Role tablolarını birleştirerek istenen veriyi alır.
    //  return PermissionRoleModel::join('permission', 'permission.permission_id', '=', 'permission_role.permission_id')
    //  ->where('permission_role.role_id', $role_id)
    //  ->where('permission.slug', $slug)
    //  ->exists(); // Eğer bu izin role_id ve slug ile eşleşiyorsa true, yoksa false döndürür.
  }
}
