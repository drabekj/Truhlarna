<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absencni_den extends Model
{
  protected $table = 'Absencni_den';
  public $timestamps = false;

  protected $fillable = ['Datum', 'ID_Zam', 'Hodiny', 'Duvod'];

  /**
    * Ziskej pole pracovnich dnu truhlare
    *
    * @param  Collection $Truhlar truhlar ke kteremu ziskame data
    * @param  Collection $Datum   mesic a rok kde kteremu chceme ziskat data
    * @param  string     $Duvod   duvod absence
    *
    * @return Array of Collections  pole kolekci absencnich dnu, posledni polozka
    *         pole je soucet absencnich dnu v poli
    */
  public static function getAbsence($Truhlar, $Datum, $Duvod){

    $queryData = Absencni_den::where('Duvod', $Duvod)->where('ID_Zam', $Truhlar->id)
    ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])->select('Datum', 'Hodiny')->get();

    for ($i=1; $i<=$Datum->numOfDays; $i++)
      $result[$i] = "";

    $sum = 0;
    foreach ($queryData as $item){
      $result[intval(date("d", strtotime($item->Datum)))] = $item->Hodiny;
      $sum += $item->Hodiny;
    }

    $result[$Datum->numOfDays+1] = $sum;

    return $result;
  }

  /**
     * Ulozi zaznam absencniho dne do databaze.
     *
     * Ulozi zaznam absencniho dne do databaze, pokud jiz existuje takovy zaznam,
     * aktualizuje jeho hodnotu.
     *
     * @param $Truhlar Object Truhlar ke kteremu se absenchni den vztahuje,
     *        objekt obsahuje id, jmeno, prijmeni
     * @param $Datum  Object  datum ke kteremu se absenchni zaznam vztahuje
     * @param $Hodiny int     hodnota ktera se ulozi atributu zaznamu Hodiny
     * @param $ID_Zam int     primarni klic truhlare ke kteremu se zaznam vztahuje
     * @param $Duvod  string  duvod absence
     * @param $den    int     den ke kteremu zaznam vztahuje
     */
  public static function store($Truhlar, $Datum, $Hodiny, $ID_Zam, $Duvod, $den){

    if ( $den < 10 )
      $den = "0" . $den;
    $formatDatum = $Datum->rok . '-' . $Datum->mesic . '-' . $den;

    $absDen = Absencni_den::where('Datum', $formatDatum)->first();

    if ($Hodiny != ""){
      if (!$absDen)
        $absDen = new Absencni_den;

      $absDen->Datum  = $formatDatum;
      $absDen->ID_Zam = $ID_Zam;
      $absDen->Hodiny = $Hodiny * 8;
      $absDen->Duvod  = $Duvod;

      $absDen->save();
    }
    // a zaroven v redchozich radcich nemam nic
    else if ($absDen && $absDen->Duvod==$Duvod){
      $absDen->delete();
    }

  }

}
