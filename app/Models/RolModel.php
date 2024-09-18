<?php

namespace App\Models;
use App\Models\PermissionModel;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolModel extends Model
{
    use HasFactory;
    protected $table = 'rol';
    protected $fillable = [ 'name'];
    protected $connection = 'sqlsrv';
    static public function tekKayitAl($id)
    {
      return RolModel::find($id);
    }
    static public function kayitAl()
    {
      return RolModel::get();
    }


}
