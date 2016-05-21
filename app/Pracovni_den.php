<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Zamestnanec;
use DB;

class Pracovni_den extends Model
{
    protected $table = 'Pracovni_den';
    public $timestamps = false;

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

    public static function store($Datum, $Hodiny, $ID_Zam, $ID_Obj, $den){
      $formatDatum = $Datum->rok . '-' . $Datum->mesic . '-' . $den;

      $pracDen = Pracovni_den::where('ID_Zam', $ID_Zam)
      ->where('ID_Obj', $ID_Obj)
      ->where('Datum', $formatDatum)->first();

      if (!$pracDen && $Hodiny){
        $pracDen = new Pracovni_den;
      }

      if ($Hodiny){
        $pracDen->Datum = $formatDatum;
        $pracDen->Hodiny = $Hodiny;
        $pracDen->ID_Zam = $ID_Zam;
        $pracDen->ID_Obj = $ID_Obj;
        
        $pracDen->save();
      }

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

      $VPs = Pracovni_den::getVPsForUser($Truhlar->id, $Datum);
      $queryData = null;

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

          /** Ziskej vsechna data pro Ukolovou Mzdu
      * @param Collection $Datum       Kolekce obsahujici rok a mesic pro ktere
      * chceme ziskat vystup.
      *
      * @return Collection  Kolekce se vsemi daty pro Ukolovou Mzdu
      **/

    public static function getDataUkolovaMzda($Datum){

        $rok = $Datum->rok;
        $mesic = $Datum->mesic;

        $VPs = Pracovni_den::getVPsAll($Datum);
        $numberOfVPs=count($VPs);

        for($j=0;$j<$numberOfVPs;$j++){
            $sum[$j]=DB::table("Pracovni_den")
            ->leftJoin('Zamestnanec', 'Zamestnanec.ID_Zam', '=', 'Pracovni_den.ID_Zam')
            ->select('Pracovni_den.ID_Zam as ID_Zam', DB::raw('sum(Hodiny) as pocetHodin'), 'Jmeno', 'Prijmeni', 'sazba')
            ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
            ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
            ->where("Id_Obj", "=", $VPs[$j]->ID_Obj)
            ->groupBy('ID_Zam')
            ->get();
            $celkoveHodin=0;
            for($i=0; $i<count($sum[$j]);$i++){
                $celkoveHodin=$celkoveHodin + $sum[$j][$i]->pocetHodin;
            }
            $jmenoObj=DB::table("Objednavka")
            ->where("Id", "=", $VPs[$j]->ID_Obj)
            ->select("Jmeno")
            ->get();
            $objednavky[$j]=(object) array(
                'ID_Obj' => $VPs[$j],
                'jmeno_Obj' => $jmenoObj[0]->Jmeno,
                'truhlari' => $sum[$j],
                'celkoveHodin' => $celkoveHodin
                );

        }
        return $objednavky;

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

      $VPs = Pracovni_den::whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
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

    public static function getOdpracovaneDny($Truhlar, $Datum){

      $result = null;
      $VPs = Pracovni_den::getVPsForUser($Truhlar->id, $Datum);
      $pracovniDnyTruhlare = Pracovni_den::getPracovniDnyTruhlare($Truhlar, $Datum, $Datum->numOfDays+5);

      $superSum = 0;
      for ( $col=1; $col<=$Datum->numOfDays; $col++ ){
        $sum = 0;
        for ($row=1; $row<=$VPs->count(); $row++){
          if ( count($pracovniDnyTruhlare[$row][$col]) ){
            $sum += $pracovniDnyTruhlare[$row][$col][0]->Hodiny / 8;
          }
        }
        $result[$col] = $sum;
        $superSum += $sum;
      }

      $result[$Datum->numOfDays+1] = $superSum;

      return $result;
    }


}
