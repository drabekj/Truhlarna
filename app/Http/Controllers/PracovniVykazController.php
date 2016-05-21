<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Objednavka;
use App\Pracovni_den;
use App\Zamestnanec;
use App\Absencni_den;
use App\IntegrityChecks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class PracovniVykazController extends Controller
{
    /**
    * Create a new controller instance.
    * Routes in this controlled are accessible only if user is authorized.
    *
    * @return void
    */
    public function __construct()
    {
      $this->middleware('auth');
    }
    
    /**
    * Funkce, která uloží jednotlivé data z DB
    * do proměnných, do kterých lze přistupovat
    *
    * @param $request je proměnná, která předává vstupní hodnoty do funkce
    * @return void @link to /rozcesti
    */
    public function store(Request $request){
      if(Auth::guest())
        return redirect('rozcesti');

      $input = $request->input();
      unset($input['_token']);

      $TruhlarID = $input['truhlar_id'];
      unset($input['truhlar_id']);

      $Datum = (object) array(
        'mesic'    => $input['mesic'],
        'rok'      => $input['rok'],
        'numOfDays' => cal_days_in_month(CAL_GREGORIAN, $input['mesic'], $input['rok']),
      );
      unset($input['mesic']);
      unset($input['rok']);

      // debug
      // var_dump($input['t2']);

      // kolik mam VPs vyplnenych
      $numberOfRows = 11;
      $parsedVPs = null;
      $parsedData = null;
      // kolik mam VPs vyplnenych

      // VPs
      for ( $row=1; $row<=$numberOfRows; $row++){
        $parsedVPs[$row] = $input[$row.'_0'];
        Objednavka::store($parsedVPs[$row]);
      }

      // Inner table data
      for ( $row=1; $row<=$numberOfRows; $row++){
        for ( $col=1; $col<=$Datum->numOfDays; $col++){
          $Hodiny = $input[$row.'_'.$col];
          $ID_Obj = $parsedVPs[$row];

          Pracovni_den::store($Datum, $Hodiny, $TruhlarID, $ID_Obj, $col);
        }
      }

      // ABSENCNI_DEN
      $duvody = ['dovolena', 'nemoc', 'svatek'];
      for ($row=2; $row<5; $row++){
        for ($col=1; $col<=$Datum->numOfDays; $col++){
          $Hodiny = $input['t2'][$row][$col];
          $Truhlar = Zamestnanec::getTruhlar($TruhlarID);

          Absencni_den::store($Truhlar, $Datum, $Hodiny, $TruhlarID, $duvody[$row-2], $col);
          }
        }

      return redirect('/rozcesti');
    }


}
