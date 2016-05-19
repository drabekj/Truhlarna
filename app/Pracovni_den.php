<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Zamestnanec;

class Pracovni_den extends Model
{
    protected $table = 'Pracovni_den';

    protected $fillable = ['datum', 'Cislo_VP', 'Hodiny', 'ID_Zam'];

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
          ->where("Cislo_VP", "=", $VPs[$row - 1]->Cislo_VP)
          ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
          ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
          ->whereRaw('extract(day from Datum) = ?', [$col])
          ->get();

        }
      }

      return $queryData;
    }
}
