<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Billets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billets', function (Blueprint $table) {
            $table->id("id_billet");
            $table->integer("qualification_urgence");
            $table->integer("id_demandeur");
            $table->integer("id_responsable")->nullable();
            $table->integer("id_operateur")->nullable();
            $table->integer("id_probleme")->nullable();
            $table->string("numero_machine", 10);
            $table->string("description_probleme", 1000)->nullable();
            $table->date("date_enregistrement");
            $table->date("date_fin")->nullable();
            $table->string("piecejointe")->nullable();
            $table->boolean("isclose")->default(false);
            $table->integer("redirection")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billets');
    }
}
