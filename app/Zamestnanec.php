<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zamestnanec extends Model
{
  protected $primaryKey = 'ID_Zam';
  protected $table = 'Zamestnanec';
  public $timestamps = false;

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
  
  /**
   * Ziskej Truhlare z databaze podle jeho ID
   * 
   * Provede dotaz na databazi vrati objek Truhlare.
   * 
   * @return Truhlar objekt obsahujici id, jmeno a prijmeni
   **/
  public static function getTruhlar($truhlarID){
    $truhlarJmeno = Zamestnanec::where('ID_Zam', '=', '$truhlarID')
    ->select("Jmeno", "Prijmeni")
    ->get();
    
    
    // nechci ti psat do kodu, ale var_dump($truhlarJmeno) by asi pomohl
    // var_dump($truhlarJmeno);

    $Truhlar = (object) array(
      'id'       => $truhlarID,
      'jmeno'    => $truhlarJmeno->Jmeno,
      'prijmeni' => $truhlarJmeno->Prijmeni
    );

    return $Truhlar;
  }
}
