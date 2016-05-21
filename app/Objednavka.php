<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objednavka extends Model
{
  protected $primaryKey = 'id';
  protected $table = 'Objednavka';
  public $timestamps = false;

  protected $fillable = ['id', 'Cislo_VP', 'Jmeno', 'Cislo_VP','Od', 'Do'];

  /**
   * Ulozi novy zaznam objednavky
   * 
   * Pokud jiz takovy zaznam nexistuje, ulozi novy zaznam objednavky pro zadane primarni klic ($id)
   * 
   * @param $id primarni klic objednavky
   */
  public static function store($id){

    $exists = Objednavka::find($id);

    if (!$exists){
      $objednavka = new Objednavka;
      $objednavka->id = $id;
      $objednavka->save();
    }

  }



}
