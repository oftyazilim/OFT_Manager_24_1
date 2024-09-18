<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class PermissionModel extends Model
{
  use HasFactory;
  protected $table = 'permission';
  protected $connection = 'sqlsrv';

  // protected $fillable = ['id', 'name', 'groupby'];

  // static public function tekKayitAl($id)
  // {
  //   return RolModel::find($id);
  // }
  // static public function kayitAl()
  // {
  //   // $izinAl = PermissionModel::groupBy('groupby')->get();
  //   // $sonuc = array();
  //   // foreach ($izinAl as $value) {
  //   //     $izinGrupAl = PermissionModel::izinGrupAl($value->groupby);
  //   //     $data = array();
  //   //     $data['permission_id'] = $value->permission_id;
  //   //     $data['name'] = $value->name;
  //   //     $group = array();
  //   //     foreach ($izinGrupAl as $valueG)
  //   //     {
  //   //         $dataG = array();
  //   //         $dataG['permission_id'] = $valueG->permission_id;
  //   //         $dataG['name'] = $valueG->name;
  //   //         $group[] = $dataG;
  //   //     }
  //   //     $data['group']=$group;
  //   //     $sonuc[]=$data;
  //   // }
  //   // return $sonuc;


  //   // Eğer burada bir hata varsa, izinAl null dönebilir
  //   // Veritabanından izinleri çek
  //   $izinAl = PermissionModel::select('groupby', 'permission_id', 'name')
  //   ->groupBy('groupby', 'permission_id', 'name')
  //   ->get();



  //   // Eğer sonuç boşsa, log dosyasına bilgi yaz
  //   if ($izinAl->isEmpty()) {
  //       Log::info('izinAl boş geldi');
  //   } else {
  //       Log::info('izinAl sonuçları:', ['izinAl' => $izinAl]);
  //   }

  //   // Sonucu işlemeye devam edin
  //   $sonuc = array();
  //   foreach ($izinAl as $value) {
  //       $izinGrupAl = PermissionModel::izinGrupAl($value->groupby);
  //       $data = array();
  //       $data['permission_id'] = $value->permission_id;
  //       $data['name'] = $value->name;
  //       $group = array();
  //       foreach ($izinGrupAl as $valueG)
  //       {
  //           $dataG = array();
  //           $dataG['permission_id'] = $valueG->permission_id;
  //           $dataG['name'] = $valueG->name;
  //           $group[] = $dataG;
  //       }
  //       $data['group'] = $group;
  //       $sonuc[] = $data;
  //   }

  //   // Sonucu geri döndür
  //   return $sonuc;
  // }

  // static public function izinGrupAl($groupby)
  // {
  //   return PermissionModel::where('groupby', '=', $groupby)->get();
  // }
}
