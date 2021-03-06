<?php

namespace App\Http\Controllers;

use DB;
use App\Pracovni_den;
use App\Zamestnanec;
use App\Absencni_den;
use App\IntegrityChecks;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RozcestiController extends Controller
{
    /**
    * Vytvori novou instanci kontroleru
    * Routy v tomto kontroleru jsou pristupne pouze pro autorizovaneho uzivatele.
    *
    * @return void
    */
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function rozcesti()
    {
        $truhlari = Zamestnanec::select(\DB::raw('CONCAT(ID_ZAM , " ", jmeno, " ", prijmeni) AS fulljmeno, ID_ZAM'))->lists('fulljmeno', 'ID_ZAM');
        return view('rozcesti')->with( 'truhlari', $truhlari);
    }

    /**
   * Funkce pracovniVykaz() předpřipraví data, která následně předá na
   * stránku /pracVykaz
   *
   * @param $vykaz_data je proměnná, ve které jsou vstupní data pro pro tuto funkci
   *        předané formulářem na rozcestií (id truhlare, datum)
   * @return vrací pole v JSON struktuře
   */
    public function pracovniVykaz(Request $vykaz_data)
    {
        if(is_null($vykaz_data->username))
        return redirect('rozcesti');
        $this->validate($vykaz_data, [
          'username' => 'exists:Zamestnanec,ID_Zam',
        ]);
        // Objekt s informacemi o truhlari podle ID z formulare
        // promenne: id, jmeno, prijmeni
        $Truhlar = Zamestnanec::getTruhlar($vykaz_data->username);
        //$Truhlar = Zamestnanec::getTruhlar($vykaz_data->ids);

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

        // Ziskej vyrobni prikazy (VPs) pro zadaneho truhlare a datum
        $VPs = Pracovni_den::getVPsForUser($Truhlar->id, $Datum);

        // Dimenze tabulek, pocet sloupcu je pro obe stejny.
        $numOfCols = $Datum->numOfDays + 5;
        // $numOfRowsT1 = $VPs->count() + 2;
        $numOfRowsT1 = 11 + 2;
        // $numOfRowsT1 = 4;
        $numOfRowsT2 = 8;

        // Ziskej dvourozmerne pole pracovnich dnu truhlar k datu
        $queryData=null;
        $T1Data = Pracovni_den::getPracovniDnyTruhlare($Truhlar,$Datum,$numOfCols);

        $odpracovaneDny = Pracovni_den::getOdpracovaneDny($Truhlar, $Datum);
        $dovolena = Absencni_den::getAbsence($Truhlar, $Datum, 'dovolena');
        $nemoc    = Absencni_den::getAbsence($Truhlar, $Datum, 'nemoc');
        $svatek   = Absencni_den::getAbsence($Truhlar, $Datum, 'svatek');

        for ($i=1; $i<=count($dovolena); $i++)
          $celkemAbsenceHodiny[$i] = $odpracovaneDny[$i] * 8 + $dovolena[$i] + $nemoc[$i] + $svatek[$i];

          // return json_encode($VPs);
        $soucetOdpracovanychHodin = Pracovni_den::getSoucetOdpracovanychHodin($Truhlar, $Datum);

        $sazba = Zamestnanec::find($Truhlar->id)->Sazba;
        $sumSazba = 0;
        $pravyPanelData = null;
        for ( $i=1; $i<=14; $i++){
          // ulozit data pro sloupecek Hodiny
          if (array_key_exists($i, $soucetOdpracovanychHodin ))
            $pravyPanelData[$Datum->numOfDays+1][$i] = $soucetOdpracovanychHodin[$i];
          else
            $pravyPanelData[$Datum->numOfDays+1][$i] = 0;

          // ulozit data pro sloupecek Sazba
          if ($i > count($VPs))
            $sazba = "";
          $pravyPanelData[$Datum->numOfDays+2][$i] = $sazba;

          // ulozit data pro sloupecek Mzda U
          $pravyPanelData[$Datum->numOfDays+3][$i] = $pravyPanelData[$Datum->numOfDays+1][$i] * $pravyPanelData[$Datum->numOfDays+2][$i];
          $sumSazba += $pravyPanelData[$Datum->numOfDays+3][$i];
        }
        $pravyPanelData[$Datum->numOfDays+3][14] =  $sumSazba;

        // celkem jednotlive dny
        $celkemJednotliveDny = null;
        $superSum = 0;
        for ( $col=1; $col<=$Datum->numOfDays; $col++){
          $sum = 0;
          for ( $row=1; $row<=count($VPs); $row++){
            // if (array_key_exists($col, $T1Data[$row] )){
            if (count($T1Data[$row][$col])){
              $sum += $T1Data[$row][$col][0]->Hodiny;
            }
          }
          $celkemJednotliveDny[$col] = $sum;
          $superSum += $sum;
        }

        return view('pracovniVykaz', [
          'Truhlar'       => $Truhlar,
          'Datum'         => $Datum,
          'VPs'           => $VPs,
          'queryData'     => $T1Data,
          'numOfCols'     => $numOfCols,
          'numOfRowsT1'   => $numOfRowsT1,
          'numOfRowsT2'   => $numOfRowsT2,
          'odpracovaneDny' => $odpracovaneDny,
          'dovolena'      => $dovolena,
          'nemoc'         => $nemoc,
          'svatek'        => $svatek,
          'celkemAbsenceHodiny' => $celkemAbsenceHodiny,
          'pravyPanelData' => $pravyPanelData,
          'celkemJednotliveDny' => $celkemJednotliveDny
        ]);

    }



   /**
   * Funkce ukolovaMzda() předpřipraví data, která následně předá na
   * stránku /ukolMzda
   *
   * @param $mzda_data je proměnná, ve které jsou vstupní data pro pro tuto funkci
   * @return vrací pole v JSON struktuře
   */
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
        $objednavky=Pracovni_den::getDataUkolovaMzda($Datum);
        return view('ukolovaMzda', [
          'Objednavky'         => $objednavky,
        ]);
    }


   /**
   * Funkce odvadeciVykaz() předpřipraví data, která následně předá na
   * stránku /ukolMzda
   *
   * @param $odvod_data je proměnná, ve které jsou vstupní data pro pro tuto funkci
   * @return vrací pole v JSON struktuře
   */
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


        // Ziskej vyrobni prikazy (VPs) pro zadane datum
        // $VPs = DB::table("Pracovni_den")
        // ->whereRaw('extract(month from Datum) = ?', [$Datum->mesic])
        // ->whereRaw('extract(year from Datum) = ?', [$Datum->rok])
        // ->select('Id_Obj')
        // ->orderBy('Id_Obj', 'asc')
        // ->distinct()->get();

       // Ziskej vyrobni prikazy (VPs) pro zadaneho truhlare a datum
      $VPs = Pracovni_den::getVPsAll($Datum);


       $numberofVPs  = count($VPs);
       $numOfRows    = $numberofVPs + 1;


       return view('odvadeciVykaz', [
         'numOfRows'    => $numOfRows,
         'numOfCols'     => $numOfCols,
         'Datum'         => $Datum,
         'VPs'           => $VPs,
       ]);

       //zkouska funkcnosti
      $objednavky=Pracovni_den::getDataUkolovaMzda($Datum);
        return view('ukolovaMzda', [
          'Objednavky'         => $objednavky,
        ]);
   }

}
