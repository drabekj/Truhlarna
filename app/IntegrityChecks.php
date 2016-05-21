<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntegrityChecks extends Model
{
public $timestamps = false;

  /**
  * Kontroluje, zda je vstup poctu hodin validni
  * 
  *
  * @param int        $vstup hodnota zapsana sekretarkou do tabulky
  *
  * @return bool    vraci true kdyz je vstup validni
  **/
  public static function checkHodiny($vstup){
      if(!is_numeric($vstup))
        return false;
      if($vstup > 24)
        return false;
      return true;
  }
  
  
  /**
  * Kontroluje, zda je vstup cislo
  * 
  *
  * @param int        $vstup hodnota zapsana sekretarkou do tabulky
  *
  * @return bool    vraci true kdyz je vstup validni
  **/
  public static function checkInt($vstup){
      if(!is_numeric($vstup))
        return false;
      return true;
  }
}
