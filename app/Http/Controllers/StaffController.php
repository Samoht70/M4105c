<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Billet;
use App\Models\Demandeur;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Operateur;
use App\Models\Probleme;
use App\Models\Notif;
use App\Models\Responsable_service;
use App\Models\TypeIntervention;
use PHPUnit\Framework\Constraint\Operator;

class StaffController extends Controller
{

    function display_home_staff(){

        if(Auth::guard("operateur")->user()){
            $user = Auth::guard("operateur")->user();
        }
        if(Auth::guard("responsable")->user()){
            $user = Auth::guard("responsable")->user();
        }
        return Inertia::render('home_staff',["user"=>$user]);
    }

    function display_billets_staff(){
        if(Auth::guard("operateur")->user()){
            $user = Auth::guard("operateur")->user();
        }

        if(Auth::guard("responsable")->user()){
            $user = Auth::guard("responsable")->user();
        }

        return Inertia::render('billet_staff',["allBillets"=>$user->billets]);
    }

    function display_info_billet_staff(Billet $billet){
        $allProbleme = Probleme::all();
        $date = date("Y-m-d");
        $allOperateur = Operateur::all();
        $allTypeInterventions = TypeIntervention::all();
        return Inertia::render("billet_infos_staff", ['billet' => $billet, "problemes" => $allProbleme, 'date' => $date,"operateurs"=>$allOperateur, 'interventions' => $allTypeInterventions]);
    }

    function billetSansOperateur() {
        $billets = Billet::withoutOperateur();
        return Inertia::render("billet_responsable", ['billets' => $billets]);
    }

    function changeBilletStaff(Billet $billet, Request $request) {
        $user = Demandeur::find($billet->id_demandeur);
        $allProbleme = Probleme::all();
        $date = date("Y-m-d");
        if(Auth::guard("responsable")->check()) {
            $validate = $request->validate([
                'importance' => ['required', 'numeric'],
                'typeprob' => ['required','nullable'],
            ]);

            $notif = new Notif();
            $notif->id_demandeur = $billet->id_demandeur;
            $notif->libelle_notif = "Bonjour, le billet concernant le problème suivant : ".$billet->description_probleme." a été modifié";
            $notif->save();
        }
        if(Auth::guard("operateur")->check() || (Auth::guard("responsable")->check() && $billet->redirection >= 3)) {
            $validate = $request->validate([
                'importance' => ['required', 'numeric'],
                'typeprob' => ['required','nullable'],
                'datefin' => ['required'],
            ]);
            $billet->date_fin = $validate['datefin'];

            $notif = new Notif();
            $notif->id_demandeur = $billet->id_demandeur;
            $notif->libelle_notif = "Bonjour, le billet concernant le problème suivant : ".$billet->description_probleme." s'est vu fixé une date de résolution. La date prévu est le ".date('d/m/Y',strtotime($validate['datefin']));
            $notif->save();
        }
        $billet->qualification_urgence = $validate['importance'];
        $billet->id_probleme = $validate['typeprob'];
        $billet->save();

        

        return back();
    }

    function allocate_ticket(Request $request,Billet $billet)
    {
        $validate = $request->validate([
            'operateur' => 'required'
        ]);

        $billet->id_operateur = $validate['operateur'];
        $billet->id_responsable = null;
        $billet->redirection++;

        $billet->save();

        return redirect('/staff/billetsSansOperateur');

    }

    function transferTicket(Billet $billet){
        
        $operateur = Operateur::find($billet->id_operateur);
        
        $responsable = Responsable_service::find($operateur->id_responsable);
        $billet->id_responsable = $responsable->id_responsable;
        $billet->id_operateur = null;
        $billet->save();
        
        return redirect('/staff/mesBillets');
    }

    public function treatment_ticket(Billet $billet, Request $request) {
        $validate = $request->validate([
            'commentaire' => ['nullable'],
            'resolve' => ['required'],
            'typeInter' => ['required']
        ]);

        $intervention = new Intervention;
        $intervention->id_billet = $billet->id_billet;
        $intervention->id_type_intervention = $validate['typeInter'];
        $intervention->commentaire = $validate['commentaire'];
        if ($validate['resolve'] == "oui") {
            $billet->isclose = true;
            $billet->save();

            $notif = new Notif();
            $notif->id_demandeur = $billet->id_demandeur;
            $notif->libelle_notif = "Bonjour, le billet concernant le problème suivant : ".$billet->description_probleme." a été fermé et le problème est résolu";
            $notif->save();
        }
        $intervention->date_intervention = date('Y-m-d');
        $intervention->save();

        return redirect('/staff/mesBillets');
    }

    public function display_statistiques() {
        $billets = Billet::where('isclose', true)->get();
        $dateMoyTheo = [];
        $dateMoyReel = [];
        foreach($billets as $billet) {
            $dateEcartTheo = (strtotime($billet->date_fin) - strtotime($billet->date_enregistrement)) / 3600 / 24;
            $interventionBillet = Intervention::where('id_billet', $billet->id_billet)->orderBy('date_intervention', 'desc')->first();
            $dateEcartReel = (strtotime($interventionBillet->date_intervention) - strtotime($billet->date_enregistrement)) / 3600 / 24;
            if ($dateEcartTheo == 0) { $dateEcartTheo += 1; }
            if ($dateEcartReel == 0) { $dateEcartReel += 1; }
            $dateMoyTheo[$billet->id_billet] = $dateEcartTheo;
            $dateMoyReel[$billet->id_billet] = $dateEcartReel;
        }
        return Inertia::render("stats", ['billets' => $billets, 'dateMoyTheo' => $dateMoyTheo, 'dateMoyReel' => $dateMoyReel]);
    }

    public function close_ticket(Billet $billet) {
        $billet->isclose = true;
        $billet->save();

        $notif = new Notif();
            $notif->id_demandeur = $billet->id_demandeur;
            $notif->libelle_notif = "Bonjour, le billet concernant le problème suivant : ".$billet->description_probleme." a été fermé et le problème n'est pas résolu";
            $notif->save();

        return back();
    }

}