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
  * Ziskej ID vyrobnich prikazu pro danneho truhlare
  * pro zadane datum.
  *
  * @param int        $TruhlarID   ID truhlare pro ktereho chceme ziskat vystup.
  * @param Collection $TruhlarID   Kolekce obsahujici rok a mesic pro ktere
  * chceme ziskat vystup.
  *
  * @return Collection  Kolekce obsahujici vyrobni prikazy filtrovane podle
  * pravidel v argumentu.
  **/
  public static function getVPs($TruhlarID, $datum){
    $VPs = Zamestnanec::find($TruhlarID)
    ->hasPracovniDny()
    ->whereRaw('extract(month from Datum) = ?', [$datum->mesic])
    ->whereRaw('extract(year from Datum) = ?', [$datum->rok])
    ->select("ID_Obj")
    ->distinct()
    ->orderBy('ID_Obj', 'asc')
    ->get();

    return $VPs;
  }

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
