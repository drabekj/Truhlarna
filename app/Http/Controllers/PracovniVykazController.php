<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Objednavka;
use App\Pracovni_den;

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

    public function store(Request $request){

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

      // kolik mam VPs vyplnenych !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
      $numberOfRows = 11;
      $parsedVPs = null;
      $parsedData = null;
      // kolik mam VPs vyplnenych !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

      // VPs
      for ( $row=1; $row<=$numberOfRows; $row++){
        $parsedVPs[$row] = $input[$row.'_0'];
        if(\IntegrityChecks::checkInt($parsedVPs[$row]))
        Objednavka::store($parsedVPs[$row]);
        else
        {
          echo "nene";
          return;
        }
      }

      // Inner table data
      for ( $row=1; $row<=$numberOfRows; $row++){
        for ( $col=1; $col<=$Datum->numOfDays; $col++){
          $Hodiny = $input[$row.'_'.$col];
          $ID_Obj = $parsedVPs[$row];

          Pracovni_den::store($Datum, $Hodiny, $TruhlarID, $ID_Obj, $col);
        }
      }

      return redirect('/pracovniVykaz');
    }


}
