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

        // $v = Validator::make($vykaz_data->all(), [
        //   'username' => 'exists:Zamestnanec,ID_Zam',
        // ]);
        //
        // if ($v->fails())
        // {
        //     return redirect()->back()->withErrors($v->errors());
        // }

        // 31 days + 5 (Cislo VP, Hod, sazba, Mzda U, Mzda C)
        $numOfCols    = 36;

        // Get Truhlar ID send from Rozcesti
        $TruhlarID    = $vykaz_data->username ;

        // Get first and last name of Truhlar for given ID
        $jmenoTruhlare = DB::table("Zamestnanec")
        ->select("Jmeno", "Prijmeni")
        ->where("ID_Zam", "=", $TruhlarID)
        ->first();

        // Get Month send from Rozcesti
        $mesic = date("m",strtotime($vykaz_data->datumPracvykaz));

        // Get Year send from Rozcesti
        $rok = date("Y",strtotime($vykaz_data->datumPracvykaz));

        // Object holding information about selected Truhlar
        $Truhlar = (object) array(
          'jmeno'    => $jmenoTruhlare->Jmeno,
          'prijmeni' => $jmenoTruhlare->Prijmeni,
          'id'       => $TruhlarID
        );

        // Object holding information about selected date
        $Datum = (object) array(
          'mesic' => $mesic,
          'rok'   => $rok
        );

        // Get the 'Vyrobni prikazy' aka VPs for selected Truhlar and date
        $VPs = DB::table("Pracovni_den")->select("Id_Obj")
        ->where("Pracovni_den.ID_Zam", "=", $Truhlar->id)
        ->join('Zamestnanec', 'Zamestnanec.ID_Zam', '=', 'Pracovni_den.ID_Zam')
        ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
        ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
        ->orderBy('Id_Obj', 'asc')->distinct()->get();

        $numberofVPs  = count($VPs);
        $numOfRows    = $numberofVPs + 2;

        $queryData=null;
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
        return view('pracovniVykaz', [
          'numOfCols'     => $numOfCols,
          'Truhlar'       => $Truhlar,
          'Datum'         => $Datum,
          'VPs'           => $VPs,
          'queryData'     => $queryData
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


        // Get Month send from Rozcesti
        $mesic = date("m",strtotime($odvod_data->datumOdVykaz));

        // Get Year send from Rozcesti
        $rok = date("Y",strtotime($odvod_data->datumOdVykaz));

        // Object holding information about selected date
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
