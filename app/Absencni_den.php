<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absencni_den extends Model
{
  protected $table = 'Absencni_den';

  protected $fillable = ['Datum', 'ID_Zam', 'Hodiny'];
  
}
