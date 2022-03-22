<?php

namespace App\Http\Controllers;

use App\Models\Billet;
use App\Models\Probleme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AttenteBilletController extends Controller
{
    public function attenteBillet() {
        $id_demandeur = Auth::guard("web")->user()->id_demandeur;
        $allBillets = Billet::findTicket($id_demandeur);
        $currentTicket = Billet::findCurrentTicket($id_demandeur);
        $closedTicket = Billet::findClosedTicket($id_demandeur);
        return Inertia::render("billet_attente", ["allBillets" => $allBillets,"currentBillets"=>$currentTicket,"closedBillets"=>$closedTicket]);
    }
    public function billetSansOperateur() {
        $allBillets = Billet::whereNull('id_operateur')->get();
        return Inertia::render("billet_sans_operateur", ["allBillets" => $allBillets]);
    }

    public function infosBillet(Billet $billet) {
        $allProbleme = Probleme::all();
        return Inertia::render("billet_infos", ['billet' => $billet, "allProblemes" => $allProbleme]);
    }

    public function modificationBillet(Billet $billet, Request $request) {
        $allProbleme = Probleme::all();


        $validate = $request->validate([
            'machine' => ['required'],
            'descr' => ['required'],
            'importance' => ['required'],
            'pjbillet' => ['nullable', 'mimes:jpeg,jpg,png,gif']
        ]);

        $typeProb = $request->input('typeprob');

        $billet->numero_machine = $validate['machine'];
        $billet->description_probleme = $validate['descr'];
        $billet->qualification_urgence = $validate['importance'];
        $billet->id_probleme = $typeProb;


        
        if ($validate['pjbillet'] != null) {
            $extension = explode('.', $validate['pjbillet']->getClientOriginalName());
            $validate['pjbillet']->storeAs('/pjBillet/',
                'pjbillet' .$billet->id_billet .'.' .$extension[1],
                'public'
            );
            $billet->piecejointe = 'pjbillet' .$billet->id_billet .'.' .$extension[1];
        }
        $billet->save();

        
        return back();
    }
}
