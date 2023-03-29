<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservering;

class ReserveringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Selecteer alle reserveringen waar de persoon_id gelijk is aan 1
            $reserveringen = Reservering::select('reserverings.id', 'persoon.voornaam', 'persoon.tussenvoegsel', 'persoon.achternaam', 'reserverings.datum', 'reserverings.aantal_uren', 'reserverings.begin_tijd', 'reserverings.eind_tijd', 'reserverings.aantal_volwassenen', 'reserverings.aantal_kinderen')
                ->join('persoon', 'persoon.id', '=', 'reserverings.persoon_id')
                ->where('persoon.id', '=', 1)
                ->orderBy('reserverings.datum', 'desc')
                ->get();

        // Return de view met de reserveringen
        return view('reserveringen.index', compact('reserveringen'));
    }
}
