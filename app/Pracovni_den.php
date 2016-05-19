<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pracovni_den extends Model
{
    protected $table = 'Pracovni_den';

    protected $fillable = ['datum', 'Cislo_VP', 'Hodiny', 'ID_Zam'];

    public function ofZamestnanec(){
      return $this->belongsTo('App\Zamestnanec', 'ID_Zam');
    }
}
