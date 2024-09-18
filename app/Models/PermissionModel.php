<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    use HasFactory;

    protected $table = 'permission';
    protected $connection = 'sqlsrv';
    // static public function kayitAl()
    // {
    //     $izinAl = PermissionModel::groupBy('groupby')->get();
    //     $sonuc = array();
    //     foreach ($izinAl as $value) {
    //         $izinGrupAl = PermissionModel::izinGrupAl($value->groupby);
    //         $data = array();
    //         $data['permission_id'] = $value->permission_id;
    //         $data['name'] = $value->name;
    //         $group = array();
    //         foreach ($izinGrupAl as $valueG)
    //         {
    //             $dataG = array();
    //             $dataG['permission_id'] = $valueG->permission_id;
    //             $dataG['name'] = $valueG->name;
    //             $group[] = $dataG;
    //         }
    //         $data['group']=$group;
    //         $sonuc[]=$data;
    //     }
    //     return $sonuc;
    // }

    // static public function izinGrupAl($groupby)
    // {
    //     return PermissionModel::where('groupby', '=' , $groupby)->get();
    // }
}
