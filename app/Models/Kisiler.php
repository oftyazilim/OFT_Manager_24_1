<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kisiler extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
      'name',
      'email',
      'password',
      'email_verified_at',
      'role_id',
      // diğer alanlar
  ];

    static public function tekKayitAl($id)
    {
        return self::find($id);
    }

    static public function kayitAl()
    {
        return User::select('users.*', 'rol.name as rol_adi')
                    ->join('rol', 'rol.id', '=' , 'users.role_id')
                    ->orderBy('users.id', 'desc')->get();
    }
    // App\Models\User.php
public function rol()
{
    return $this->belongsTo(RolModel::class, 'role_id');
}
}
