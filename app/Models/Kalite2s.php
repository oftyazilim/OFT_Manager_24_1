<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kalite2s extends Model
{
  use HasFactory;
  protected $table = 'mamulstok2';
  protected $connection = 'sqlSekerpinar';

  // protected $guarded = [];

  protected $fillable = [
    'mamul',
    'boy',
    'adet2',
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
    'basildi',
    'kalinlik'
  ];
}
