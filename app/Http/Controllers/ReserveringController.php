<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservering;
use App\Models\PakketOptie;

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
        // De reserveringen moet op datum aflopend zijn
        // Vraag de voornaam, tussenvoegsel, achternaam en combineer deze tot een volledige naam
        // Datum, AantalUren, BeginTijd, EindTijd, AantalVolwassenen, AantalKinderen uit de reservering tabel
        // Selecteer de optiepakket naam uit de pakket_opties tabel via de foreign key pakket_optie_id in de reservering tabel (join)

        // Check of de datum niet leeg is
        if (!empty($request->date)) {
            // Selecteer alle reserveringen vanaf de meegegeven datum
            $reserveringen = Reservering::select('reserverings.id', 'persoon.voornaam', 'persoon.tussenvoegsel', 'persoon.achternaam', 'reserverings.datum', 'reserverings.aantal_uren', 'reserverings.begin_tijd', 'reserverings.eind_tijd', 'reserverings.aantal_volwassenen', 'reserverings.aantal_kinderen', 'pakket_opties.naam')
                ->join('pakket_opties', 'pakket_opties.id', '=', 'reserverings.pakket_optie_id')
                ->join('persoon', 'persoon.id', '=', 'reserverings.persoon_id')
                ->where('persoon.id', '=', 1)
                ->where('reserverings.datum', '>=', $request->date)
                ->orderBy('reserverings.datum', 'desc')
                ->get();

            // Check of er wel reserveringen zijn
            if ($reserveringen->isEmpty()) {
                // Geen reserveringen gevonden
                return redirect()->route('reserveringen.index')->with('error', 'Er zijn geen reserveringen gevonden voor de datum: ' . $request->date);
            }
        } else {
            // Selecteer alle reserveringen voor die persoon
            $reserveringen = Reservering::select('reserverings.id', 'persoon.voornaam', 'persoon.tussenvoegsel', 'persoon.achternaam', 'reserverings.datum', 'reserverings.aantal_uren', 'reserverings.begin_tijd', 'reserverings.eind_tijd', 'reserverings.aantal_volwassenen', 'reserverings.aantal_kinderen', 'pakket_opties.naam')
                ->join('pakket_opties', 'pakket_opties.id', '=', 'reserverings.pakket_optie_id')
                ->join('persoon', 'persoon.id', '=', 'reserverings.persoon_id')
                ->where('persoon.id', '=', 1)
                ->orderBy('reserverings.datum', 'desc')
                ->get();
        }

        // Return de view met de reserveringen
        return view('reserveringen.index', compact('reserveringen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Selecteer alle PakketOptie
        $pakketOpties = PakketOptie::all();

        // Check of er wel opties zijn
        if ($pakketOpties->isEmpty()) {
            // Opties zijn leeg error naar index
            return redirect()->route('reserveringen.index')->with('error', 'Er zijn geen opties gevonden');
        }

        // Return de view met de reservering id ($id) en de opties
        return view('reserveringen.edit', compact('id', 'pakketOpties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        // Zet de nieuwe geslecteerde opties in de database
        $reservering = Reservering::find($id);

        // Check of er kinderen aanwezig zijn als vrijgezellenfeest (id 4) is gekozen dan alert dat "Het optiepakket vrijgezellenfeest is niet bedoelt voor kinderen"
        if ($request->input('pakket_optie_id') == 4 && $reservering->aantal_kinderen > 0) {
            // Return naar de index met een error message
            return redirect()->route('reserveringen.edit', $id)->with('error', 'Het optiepakket vrijgezellenfeest is niet bedoelt voor kinderen');
        }

        $reservering->pakket_optie_id = $request->input('pakket_optie_id');
        $reservering->save();

        // Return naar de index met een success message
        return redirect()->route('reserveringen.index')->with('success', 'Reservering is succesvol aangepast');
    }
}
