<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objednavka extends Model
{
  protected $primaryKey = 'id';
  protected $table = 'Objednavka';

  protected $fillable = [ 'Jmeno', 'Cislo_VP','Od', 'Do'];
}
