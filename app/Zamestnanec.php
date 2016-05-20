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

  /**
  * Podle ID truhlare v parametru dohleda jmeno a prijmeni a vsechna data vrati v
  * objektu.
  *
  * @param int $truhlarID ID truhlare ktereho hledame
  *
  * @return Objekt obsahujici id,jmeno a prijmeni
  */
  public static function getTruhlar($truhlarID){
    $truhlarJmeno = Zamestnanec::find($truhlarID)
    ->select("Jmeno", "Prijmeni")
    ->first();

    $Truhlar = (object) array(
      'id'       => $truhlarID,
      'jmeno'    => $truhlarJmeno->Jmeno,
      'prijmeni' => $truhlarJmeno->Prijmeni
    );

    return $Truhlar;
  }
}
