<?php

namespace Database\Seeders;

use App\Models\Billet;
use App\Models\Competence;
use App\Models\Demandeur;
use App\Models\Est_qualifiee;
use App\Models\Operateur;
use App\Models\PrisEnCharge;
use App\Models\Probleme;
use App\Models\Responsable_service;
use App\Models\TypeIntervention;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Demandeur::create([
            "nom"=>"Deloule","prenom" => "Françoise", "email" => "francoise.deloule@gmail.com","password" => Hash::make("demandeur1")
        ]);

        Demandeur::create([
            "nom"=>"Mulh","prenom" => "Alexandre", "email" => "alexandre.mulh@gmail.com","password" => Hash::make("demandeur2")
        ]);

        Billet::create([
            "numero_machine" => "D250-S04", "date_enregistrement" => date("Y/m/d"), "qualification_urgence" => 3, "id_demandeur" => 1,"id_operateur"=>1,
            "id_probleme" => 1,"description_probleme" =>"Odoo crash"
        ]);

        Billet::create([
            "numero_machine" => "D45", "date_enregistrement" => date("Y/m/d"), "qualification_urgence" => 10, "id_demandeur" => 1,"id_operateur"=>2,
            "id_probleme" => 2,"description_probleme" =>"Écran cassé"
        ]);

        Billet::create([
            "numero_machine" => "D875", "date_enregistrement" => date("Y/m/d"), "qualification_urgence" => 6, "id_demandeur" => 2,"id_responsable"=>1,
            "description_probleme" =>"Je connais rien à l'internet"
        ]);

        Billet::create([
            "numero_machine" => "D75", "date_enregistrement" => date("Y/m/d"), "qualification_urgence" => 5, "id_demandeur" => 2,"id_responsable"=>1,
            "description_probleme" =>"Je connais rien à l'internet", "redirection"=>3
        ]);

        Operateur::create(["prenom" => "Bob","nom"=>"Augrosobe","id_responsable" => 1,"email"=>"bob.augrosobe@gmail.com","password" => Hash::make("operateur1")]);

        Operateur::create(["prenom" => "logan","nom"=>"metral","id_responsable" => 1,"email"=>"logan.metral@gmail.com","password" => Hash::make("operateur2")]);

        Responsable_service::create(["nom"=>"Goi","prenom"=>"Lucas","email"=>"lucas.goi@gmail.com","password"=>Hash::make("responsable")]);

        Competence::create(["nom_competence"=>"logiciel"]);
        Competence::create(["nom_competence"=>"matériel"]);
        Competence::create(["nom_competence"=>"utilisateur"]);

        TypeIntervention::create(["type_intervention" => "réparation"]);
        TypeIntervention::create(["type_intervention" => "remplacement"]);
        TypeIntervention::create(["type_intervention" => "désinstallation"]);

        Est_qualifiee::create(["id_competence"=>1,"id_operateur"=>1]);
        Est_qualifiee::create(["id_competence"=>3,"id_operateur"=>1]);
        Est_qualifiee::create(["id_competence"=>2,"id_operateur"=>2]);

        Probleme::create(["type_probleme" => "logiciel"]);
        Probleme::create(["type_probleme" => "matériel"]);
        Probleme::create(["type_probleme" => "utilisateur"]);
    }
}
