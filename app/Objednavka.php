<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objednavka extends Model
{
  protected $primaryKey = 'id';
  protected $table = 'Objednavka';
  public $timestamps = false;

  protected $fillable = ['id', 'Cislo_VP', 'Jmeno', 'Cislo_VP','Od', 'Do'];

  public static function store($id){

    $exists = Objednavka::find($id);

    if (!$exists){
      $objednavka = new Objednavka;
      $objednavka->id = $id;
      $objednavka->save();
    }

  }



}
