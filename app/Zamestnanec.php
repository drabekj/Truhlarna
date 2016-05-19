<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zamestnanec extends Model
{
  protected $primaryKey = 'ID_Zam';
  protected $table = 'Zamestnanec';

  protected $fillable = [ 'Jmeno', 'Prijmeni'];

  public function hasPracovniDny(){
    return $this->hasMany('App\Pracovni_den' , 'ID_Zam');
  }
}
