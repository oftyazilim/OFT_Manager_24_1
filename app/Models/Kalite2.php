<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kalite2 extends Model
{
  use HasFactory;
  protected $table = 'mamulstok2';
  protected $connection = 'sqlAkyazi';

  // protected $guarded = [];

  protected $fillable = [
    'mamul',
    'boy',
    'kantarkg',
    'adet',
    'kg',
    'nevi',
    'pkno',
    'hat',
    'tarih',
    'saat',
    'operator',
    'mamulkodu',
    'basildi'
  ];
}
