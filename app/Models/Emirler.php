<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emirler extends Model
{
    use HasFactory;
    protected $table = 'oftt_01_emirleris';
    protected $guarded = [];

  //   protected $fillable = [
  //     'HAT',
  //     'MAMUL',
  //     'BOY',
  //     'MIKTAR',
  // ];
}