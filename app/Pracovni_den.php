<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Zamestnanec;
use App\IntegrityChecks;
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

    /**
     * Ulozi zaznam pracovniho dne do databaze.
     *
     * Ulozi zaznam pracovniho dne do databaze, pokud jiz existuje takovy zaznam,
     * aktualizuje jeho hodnotu.
     *
     * @param $Datum  datum ke kteremu se pracovni zaznam vztahuje
     * @param $Hodiny hodnota ktera se ulozi atributu zaznamu Hodiny
     * @param $ID_Zam primarni klic zamestnance ke kteremu se zaznam vztahuje
     * @param $ID_Obj primarni klic objednavky ke ktere se zaznam vztahuje
     * @param   $den    den ke kteremu sezaznam vztahuje
     */
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
      if ($pracDen && !$Hodiny){
        $pracDen->delete();
      }

    }

    /**
    * Ziskej dvourozmerne pole pracovnich dnu truhlare
    *
    * @param  Collection $Truhlar truhlar ke kteremu ziskame data
    * @param  Collection $Datum   mesic a rok kde kteremu chceme ziskat data
    * @param  Collection $numOfCols   pocetPracovnich dnu v mesici
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
        $objednavky=null;
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

    /**
     * Vrati pole zaznamu pracovnich dnu vztazenuch k dannemu truhlari a datu
     *
     * Data v poli jsou soucen odpracovanych hodin v danny den vydeleny cislem 8.
     * To znamena kolik bylo odpracovano z 8-mi hodinove pracovni doby.
     *
     * @param $Truhlar  Objekt truhlare pro ktery chceme ziskat vysledek
     *        obsehujici id, jmeno, prijmeni truhlare.
     * @param $Datum    Objekt data pro ktery chceme ziskat vysledek,
     *        obsahujici id, jmeno, prijmeni.
     */
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

    /**
     * Vrati pole zaznamu pracovnich dnu vztazenuch k dannemu truhlari a datu
     *
     * Data v poli jsou soucen odpracovanych hodin v danny den vydeleny cislem 8.
     * To znamena kolik bylo odpracovano z 8-mi hodinove pracovni doby.
     *
     * @param $Truhlar  Objekt truhlare pro ktery chceme ziskat vysledek
     *        obsehujici id, jmeno, prijmeni truhlare.
     * @param $Datum    Objekt data pro ktery chceme ziskat vysledek,
     *        obsahujici id, jmeno, prijmeni.
     */
    public static function getSoucetOdpracovanychHodin($Truhlar, $Datum){

      $result = null;
      $VPs = Pracovni_den::getVPsForUser($Truhlar->id, $Datum);
      $pracovniDnyTruhlare = Pracovni_den::getPracovniDnyTruhlare($Truhlar, $Datum, $Datum->numOfDays+5);
    
      $result = null;
      $sum = 0;
      $superSum = 0;
      // pro kazdy vyrobni prikaz
      for ( $row=1; $row<=count($pracovniDnyTruhlare); $row++ ){
        // pro kazdy den co se pracovalo na vyrobnim prikazu
        for ( $col=1; $col<=$Datum->numOfDays; $col++ ){
          if ( count($pracovniDnyTruhlare[$row][$col]) ){
            $sum += $pracovniDnyTruhlare[$row][$col][0]->Hodiny;
          }
        }
        $result[$row] = $sum;
        $superSum += $sum;
        $sum = 0;
      }

      // na 12. radku je C.hod.ukol.
      $result[12] = $superSum;
      $result[13] = 0;
      $result[14] = $result[12 ]+ $result[13];

      return $result;
    }
}
