<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absencni_den extends Model
{
  protected $table = 'Absencni_den';
  // public $timestamps = false;

  protected $fillable = ['Datum', 'ID_Zam', 'Hodiny', 'Duvod'];

  public static function getAbsence($Truhlar, $Datum, $Duvod){

    $queryData = Absencni_den::where('Duvod', $Duvod)->where('ID_Zam', $Truhlar->id)
    ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])->select('Datum', 'Hodiny')->get();

    for ($i=1; $i<=$Datum->numOfDays; $i++)
      $result[$i] = "";

    $sum = 0;
    foreach ($queryData as $item){
      $result[intval(date("d", strtotime($item->Datum)))] = $item->Hodiny / 8;
      $sum += $item->Hodiny / 8;
    }

    $result[$Datum->numOfDays+1] = $sum;

    return $result;
  }

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
