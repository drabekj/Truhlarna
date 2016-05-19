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
        $VPs = DB::table("Pracovni_den")->select("Cislo_VP")
        ->where("Pracovni_den.ID_Zam", "=", $Truhlar->id)
        ->join('Zamestnanec', 'Zamestnanec.ID_Zam', '=', 'Pracovni_den.ID_Zam')
        ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
        ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
        ->orderBy('cislo_VP', 'asc')->distinct()->get();

        $numberofVPs  = count($VPs);
        $numOfRows    = $numberofVPs + 2;

        $queryData;
        for ($row = 1; $row <= $numberofVPs; $row++) {
          for ($col = 1; $col <= $numOfCols; $col++) {
            $queryData[$row][$col] = DB::table("Pracovni_den")
            ->select('Pracovni_den.Hodiny')
            ->where("Pracovni_den.ID_Zam", "=", $Truhlar->id)
            ->where("Cislo_VP", "=", $VPs[$row - 1]->Cislo_VP)
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

    public function ukolovaMzda()
    {
        return view('ukolovaMzda');
    }

    public function odvadeciVykaz()
    {
        return view('odvadeciVykaz');
    }

}
