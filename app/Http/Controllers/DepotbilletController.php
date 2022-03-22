<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Billet;
use App\Models\Probleme;
use App\Models\Operateur;
use App\Models\Responsable_service;
use DateTime;
use Illuminate\Support\Facades\Date;

use function PHPUnit\Framework\isNull;

class DepotbilletController extends Controller
{

    public function depotbillet() {
        return Inertia::render("depotbillet",["allProblemes"=>Probleme::all()]);
    }


    public function ValidationBillet(Request $request) {
      
        $user = Auth::guard('web')->user();

        $operateur = null;
        $responsable = null;

        $prequal = $request->input('pre_qual');


      
        $validate = $request->validate([
            'num_machine' => 'required |nullable',
            'description' => 'required | max:255 |nullable',
            'pets' => 'required |nullable',
            'fichier' => 'mimes:jpeg,jpg,png,gif|nullable'
        ]);


        $billet = new Billet();
        $billet->qualification_urgence =$validate['pets'];
        $billet->numero_machine = $validate['num_machine'];
        $billet->description_probleme = $validate['description'];
        if($validate['fichier'] != null){
            $billetId = Billet::max('id_billet')+1;
            $extension =  explode('.',$validate['fichier']->getClientOriginalName());
            $billet->piecejointe = 'pjbillet'.$billetId.'.'.$extension[1];

            $request->fichier->storeAs('/pjBillet/','pjbillet'.$billetId.'.'.$extension[1],'public');
        }
        $billet->date_enregistrement = date("Y/m/d");
        if($prequal != null){
            $billet->id_probleme = $prequal;
            $operateurs = Operateur::findByTypeProbleme($prequal);
            if(count($operateurs) > 1){
                $min = 999999999999999999999;
                foreach($operateurs as $oneOperateur){
                    if(count($oneOperateur->billets) < $min){
                        $min = count($oneOperateur->billets);
                        $operateur = $oneOperateur;
                    }
                }
            }
            else{
                $operateur = $operateurs[0];
            }
            $billet->id_operateur = $operateur->id_operateur;
        }
        else{
            $responsable = Responsable_service::find(1);
            $billet->id_responsable = $responsable->id_responsable;
        }
        
        
        $billet->id_demandeur = $user->id_demandeur;
        $billet->date_enregistrement = Date::now();

        $billet->save();
        
        return redirect('/attentebillet');
        
    }

}
