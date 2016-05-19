<?php

namespace App\Http\Controllers;

use DB;
use App\Pracovni_den;
use App\Zamestnanec;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RozcestiController extends Controller
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

    public function rozcesti()
    {
        return view('rozcesti');
    }

    public function pracovniVykaz(Request $vykaz_data)
    {
        $this->validate($vykaz_data, [
          'username' => 'exists:Zamestnanec,ID_Zam',
        ]);

        // Objekt s informacemi o truhlari podle ID z formulare
        // promenne: id, jmeno, prijmeni
        $Truhlar = Zamestnanec::getTruhlar($vykaz_data->username);

        // Ziskej mesic datumu z formulare na rozcesti
        $mesic = date("m",strtotime($vykaz_data->datumPracvykaz));

        // Ziskej rok datumu z formulare na rozcesti
        $rok = date("Y",strtotime($vykaz_data->datumPracvykaz));

        // Object holding information about selected date
        $Datum = (object) array(
          'mesic' => $mesic,
          'rok'   => $rok,
          'numOfDays' => cal_days_in_month(CAL_GREGORIAN, $mesic, $rok)
        );

<<<<<<< HEAD
        // Get the 'Vyrobni prikazy' aka VPs for selected Truhlar and date
        $VPs = DB::table("Pracovni_den")->select("Id_Obj")
        ->where("Pracovni_den.ID_Zam", "=", $Truhlar->id)
        ->join('Zamestnanec', 'Zamestnanec.ID_Zam', '=', 'Pracovni_den.ID_Zam')
        ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
        ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
        ->orderBy('Id_Obj', 'asc')->distinct()->get();
=======
        // Ziskej vyrobni prikazy (VPs) pro zadaneho truhlare a datum
        $VPs = Zamestnanec::getVPs($Truhlar->id, $Datum);
>>>>>>> 0c89eab5f850980337b35de4799a7bdd88bab48b

        // Dimenze tabulek, pocet sloupcu je pro obe stejny.
        $numOfCols = $Datum->numOfDays + 5;
        $numOfRowsT1 = $VPs->count() + 2;
        $numOfRowsT2 = 8;

        // Ziskej dvourozmerne pole pracovnich dnu truhlar k datu
        $queryData=null;
<<<<<<< HEAD
        for ($row = 1; $row <= $numberofVPs; $row++) {
          for ($col = 1; $col <= $numOfCols; $col++) {
            $queryData[$row][$col] = DB::table("Pracovni_den")
            ->select('Pracovni_den.Hodiny')
            ->where("Pracovni_den.ID_Zam", "=", $Truhlar->id)
            ->where("Id_Obj", "=", $VPs[$row - 1]->Id_Obj)
            ->join('Zamestnanec', 'Zamestnanec.ID_Zam', '=', 'Pracovni_den.ID_Zam')
            ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
            ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
            ->whereRaw('extract(day from Datum) = ?', [$col])
            ->get();
          }
        }
=======
        $queryData = Pracovni_den::getPracovniDnyTruhlare($Truhlar,$Datum,$numOfCols);

>>>>>>> 0c89eab5f850980337b35de4799a7bdd88bab48b
        return view('pracovniVykaz', [
          'Truhlar'       => $Truhlar,
          'Datum'         => $Datum,
          'VPs'           => $VPs,
          'queryData'     => $queryData,
          'numOfCols'     => $numOfCols,
          'numOfRowsT1'   => $numOfRowsT1,
          'numOfRowsT2'   => $numOfRowsT2
        ]);
    }



    public function ukolovaMzda(Request $mzda_data)
    {
         // Get Year send from Rozcesti
        $rok = date("Y",strtotime($mzda_data->datumUklMzda));
         // Get Month send from Rozcesti
        $mesic = date("m",strtotime($mzda_data->datumUklMzda));

        // Object holding information about selected date
        $Datum = (object) array(
          'mesic' => $mesic,
          'rok'   => $rok
        );
        
        $VPs=DB::table("Pracovni_den")
        ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
        ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
        ->select('Id_Obj')
        ->orderBy('Id_Obj', 'asc')
        ->distinct()->get();
        $numberOfVPs=count($VPs);

       /* $sum=DB::table("Pracovni_den")
        ->join('Zamestnanec', 'Zamestnanec.ID_Zam', '=', 'Pracovni_den.ID_Zam')
        ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
        ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
        ->where("Id_Obj", "=", $VPs[0]->Id_Obj)
        ->select('Id_Zam', DB::raw('sum(Hodiny) as total'))
        ->groupBy('ID_Zam')
        ->get();*/
        $sum=DB::table("Pracovni_den")
        ->select('Id_Zam', DB::raw('sum(Hodiny) as total'))
        ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
        ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
        ->where("Id_Obj", "=", $VPs[0]->Id_Obj)
        ->groupBy('ID_Zam')
        ->get();
        echo $sum[0]->total ." ". $sum[0]->Id_Zam;
        // echo $sum;
        return view('ukolovaMzda', [
          'Datum'         => $Datum,
        ]);
        }



    public function odvadeciVykaz(Request $odvod_data)
   {
       // 31 days + 5 (Cislo VP, Hod, sazba, Mzda U, Mzda C)
       $numOfCols    = 36;


       // Ziskej mesic datumu z formulare na rozcesti
       $mesic = date("m",strtotime($odvod_data->datumOdVykaz));

       // Ziskej rok datumu z formulare na rozcesti
       $rok = date("Y",strtotime($odvod_data->datumOdVykaz));

       $Datum = (object) array(
         'mesic' => $mesic,
         'rok'   => $rok
       );


        // Get the 'Vyrobni prikazy' aka VPs for selected date
        $VPs = DB::table("Pracovni_den")
        ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
        ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
        ->select('Id_Obj')
        ->orderBy('Id_Obj', 'asc')
        ->distinct()->get();

       // Ziskej vyrobni prikazy (VPs) pro zadaneho truhlare a datum
//       $VPs = Zamestnanec::getVPs($Truhlar->id, $Datum);


       $numberofVPs  = count($VPs);
       $numOfRows    = $numberofVPs + 1;


       return view('odvadeciVykaz', [
         '$numOfRows'    => $numOfRows,
         'numOfCols'     => $numOfCols,
         'Datum'         => $Datum,
         'VPs'           => $VPs,
       ]);
   }

}
