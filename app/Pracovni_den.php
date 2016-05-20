<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Zamestnanec;
use DB;

class Pracovni_den extends Model
{
    protected $table = 'Pracovni_den';

    protected $fillable = ['datum', 'ID_Obj', 'Hodiny', 'ID_Zam'];

    /**
    * Vztah k zamestnanci
    *
    * Jeden pracovni den, patri prave k jednomu zamestnanci.
    *
    * @return Kolekce se zamestnancem ke kteremu patri pracovni den
    */
    public function ofZamestnanec(){
      return $this->belongsTo('App\Zamestnanec', 'ID_Zam');
    }

    /**
    * Ziskej dvourozmerne pole pracovnich dnu truhlare
    *
    * @param  Collection $Truhlar truhlar ke kteremu ziskame data
    * @param  Collection $Datum   mesic a rok kde kteremu chceme ziskat data
    *
    * @return Collection          Dvourozmerne pole kolekci pracovnich dnu
    */
    public static function getPracovniDnyTruhlare($Truhlar, $Datum, $numOfCols){
      $VPs = Zamestnanec::getVPs($Truhlar->id, $Datum);

      for ($row = 1; $row <= $VPs->count(); $row++) {
        for ($col = 1; $col <= $numOfCols; $col++) {

          $queryData[$row][$col] = Pracovni_den::where('ID_Zam', '=', $Truhlar->id)
          ->where("ID_Obj", "=", $VPs[$row - 1]->ID_Obj)
          ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
          ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
          ->whereRaw('extract(day from Datum) = ?', [$col])
          ->get();

        }
      }

      return $queryData;
    }

      /**
      * Ziskej ID vyrobnich prikazu pro danneho truhlare
      * pro zadane datum.
      *
      * @param int        $TruhlarID   ID truhlare pro ktereho chceme ziskat vystup.
      * @param Collection $Datum       Kolekce obsahujici rok a mesic pro ktere
      * chceme ziskat vystup.
      *
      * @return Collection  Kolekce obsahujici vyrobni prikazy filtrovane podle
      * pravidel v argumentu.
      **/
      public static function getVPsForUser($TruhlarID, $Datum){
        $VPs = Pracovni_den::all()
        ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
        ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
        ->select("ID_Obj")
        ->distinct()
        ->orderBy('ID_Obj', 'asc')
        ->get();

        return $VPs;
      }

      /**
      * Ziskej ID vsech vyrobnich prikazu pro zadane datum.
      *
      * @param Collection $Datum   Kolekce obsahujici rok a mesic pro ktere
      * chceme ziskat vystup.
      *
      * @return Collection  Kolekce obsahujici vyrobni prikazy filtrovane podle
      * pravidel v argumentu.
      **/
      public static function getVPsAll($Datum){
        $VPs = Pracovni_den::whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
        ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
        ->select("ID_Obj")
        ->distinct()
        ->orderBy('ID_Obj', 'asc')
        ->get();
        
        return $VPs;
      }
}
