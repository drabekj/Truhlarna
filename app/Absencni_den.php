<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absencni_den extends Model
{
  protected $table = 'Absencni_den';

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

}
