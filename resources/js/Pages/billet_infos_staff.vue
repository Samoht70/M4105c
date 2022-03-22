<template>
  <div class="d-flex flex-column min-vh-100">
    <Header
      :title="title + billet.id_billet"
      :deconnexion="deconnexion"
      :connectedUser="connectedUser"
    ></Header>
    <form
      @submit.prevent="form.post($route('changeBilletStaff', {billet: billet.id_billet}))"
      class="mt-5 d-flex flex-column"
      enctype="multipart/form-data"
    >
      <div id="formulaire" class="d-flex justify-content-around">
        <div
          id="container"
          class="d-flex flex-column align-items-center container1"
        >
          <div id="machine" class="d-flex flex-row mb-4">
            <div class="mr-3">Numéro de la machine :</div>
            <input
              type="text"
              name="machine2"
              v-model="form.machine"
              class="font-weight-bold text-center"
              readonly
            />
          </div>
          <div id="description" class="mb-4">
            <p class="h5">Description du problème</p>
            <textarea
              name="descr"
              id="descr"
              cols="30"
              rows="3"
              v-model="form.descr"
              readonly
            ></textarea>
          </div>
          <div id="qualification" class="d-flex mb-5">
            <div class="mr-2">Importance du billet</div>
            <input
              type="text"
              name="importance"
              v-model="form.importance"
              class="font-weight-bold text-center js"
              @input="changeButton"
              v-if="billet.isclose == false"
            />
            <b v-if="form.errors.importance" class="text-danger">{{form.errors.importance}}</b>
            <input
              type="text"
              name="importance"
              v-model="form.importance"
              class="font-weight-bold text-center js"
              v-if="billet.isclose == true"
              readonly
            />
          </div>
          <div id="pj">
            <p class="mr-2">Pièces jointes</p>
            <img v-if="billet.piecejointe != null" :src="'/pjBillet/' + billet.piecejointe" alt="Image du problème" />
            <b v-if="form.errors.pjbillet" class="text-danger">{{form.errors.pjbillet}}</b>
          </div>
        </div>

        <div
          id="container"
          class="d-flex flex-column align-items-center container2"
        >
          <div id="prequalif" class="mb-5">
            <p class="h5">Pré-qualification du type de problème</p>
            <select name="typeprob" id="typeprob" v-model="form.typeprob" class=" js" @input="changeButton" v-if="billet.isclose == false">
              <option value="">Choisir un type de problème</option>
              <option
                v-for="probleme in problemes"
                :key="probleme.id_probleme"
                :value="probleme.id_probleme"
              >
                {{ firstLetterUppercase(probleme.type_probleme) }}
              </option>
            </select>
            <input
              type="text"
              :value="firstLetterUppercase(billet.probleme.type_probleme)"
              readonly
              v-if="billet.isclose == true">
          </div>
          <div id="date-depot" class="d-flex align-items-center mb-5">
            <div class="mr-4 w-75">Date de dépôt du billet :</div>
            <input
              type="date"
              name="datedebut"
              v-model="form.datedebut"
              class="text-center font-weight-bold w-50"
              readonly
            />
          </div>
          <div id="date-fin" class="d-flex align-items-center mb-1">
            <div class="mr-4">Date de fin prévue du billet :</div>
            <input
              type="date"
              name="datefin"
              :min="date"
              v-model="form.datefin"
              class="text-center font-weight-bold js"
              v-if="(connectedUser == 'operateur' || billet.redirection == 3) && billet.isclose == false && billet.date_fin == null"
              @change="changeButton"
            />
            <input
              type="date"
              name="datefin"
              :min="date"
              v-model="this.form.datefin"
              class="text-center font-weight-bold js"
              v-if="billet.isclose == true || billet.date_fin != null || (connectedUser == 'responsable' && billet.redirection < 3)" readonly
            />
          </div>
          <p v-if="form.errors.datefin" class="text-danger">{{form.errors.datefin}}</p>
          <p v-if="billet.date_fin == null && connectedUser=='operateur'" class="text-danger">Une date de fin doit être renseignée pour traiter le billet</p>
        </div>
      </div>
      <div id="submit" class="mt-4 text-center">
        <b-button class="" id="valider" v-if="connectedUser == 'responsable' && billet.isclose == false && billet.redirection < 3" v-on:click="displayFormOperateur">
          Attribuer le billet
          <b-spinner small v-if="form.processing" class="ml-2"></b-spinner>
        </b-button>

        <b-button class="" id="valider" v-if="connectedUser == 'operateur' && billet.isclose == false">
          <Link :href="$route('transfert', {billet: billet.id_billet})">Tranférer le billet</Link>
          <b-spinner small v-if="form.processing" class="ml-2"></b-spinner>
        </b-button>

        <b-button class="d-none" id="modifier" v-if="billet.isclose == false" type="submit">
            Modifier le billet
          <b-spinner small v-if="form.processing" class="ml-2"></b-spinner>
        </b-button>

        <b-button class="" id="traiter" v-if="billet.isclose == false && (connectedUser == 'operateur' || billet.redirection == 3)" v-on:click="displayFormTreatment">
          Traiter le billet
          <b-spinner small v-if="form.processing" class="ml-2"></b-spinner> 
        </b-button>

        <b-button class="" v-if="billet.isclose == false">
          <Link :href="$route('closeTicket', {billet: billet.id_billet})">Fermer le billet</Link>
          <b-spinner small v-if="form.processing" class="ml-2"></b-spinner>
        </b-button>
        

      </div>
      <div id="quit" class="mt-4 text-center">
        <b-button class="quitter">
          <Link :href="$route('billetsStaff.view')" class="">Quitter le billet</Link>
        </b-button>
      </div>
    </form>

    <div class="text-center mt-3" v-if="billet.isclose == true">
      <h2 class="text-success">Le billet est fermé</h2>
    </div>

    <div class="text-center mt-3 text-danger">
      <p>Le bouton "Fermer le billet" est à utiliser si le problème n'est pas resolvable</p>
    </div>
    
    <div class="position-absolute w-100 h-100 bg-dark d-none" v-if="connectedUser == 'responsable'" id="divAAfficher">
        <div id="overlay" class="shadow bg-light">
          <form class="container" @submit.prevent="formOperateur.post($route('allocateTicket', {billet: billet.id_billet}))">
            <div class="row">
              <div class="col d-flex flex-column">
                <h3 class="text-center">A quel opérateur attribuer vous ce billet?</h3>
                <select name="operateur" class="form-select" v-model="formOperateur.operateur">
                  <option value="">Choisissez un opérateur</option>
                  <option v-for="operateur in operateurs" :key="operateur.id_operateur" :value="operateur.id_operateur">
                    {{firstLetterUppercase(operateur.prenom)}} {{firstLetterUppercase(operateur.nom)}}
                  </option>
                </select>
                <b v-if="formOperateur.errors.operateur" class="text-danger">{{formOperateur.errors.operateur}}</b>
              </div>
            </div>
            <div class="row mt-5">
              <div class="col">
                <b-button type="submit">Attribuer</b-button>
              </div>
            </div>
          </form>
        </div>
        <div id="cruce" v-on:click="hideFormOperateur">
          <a type="button" class="close text-danger" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
    </div>


    <div class="position-absolute w-100 h-100 bg-dark d-none" v-if="billet.date_fin != null" id="divformtreatment">
        <div id="overlay" class="shadow bg-light">
          <form class="container d-flex flex-column align-items-center my-5" @submit.prevent="formTreatment.post($route('treatmentTicket', {billet: billet.id_billet}))">
            <div class="row">
              <div class="col d-flex flex-column">
                <h2 class="text-center mb-4">Traitement du billet</h2>
                <div id="commentaire">
                  <p class="font-weight-bolder">Commentaire :</p>
                  <textarea name="commentaire" id="com" cols="30" rows="2" v-model="formTreatment.commentaire"></textarea>
                </div>
                <div id="isresolve" class="mt-3">
                  <p class="mb-0 font-weight-bolder">Le billet est-il résolu ?</p>
                  <div id="yes">
                    <input type="radio" id="yes" name="resolve" v-model="formTreatment.resolve" value="oui">
                    <label for="yes">Oui</label>
                  </div>
                  <div id="no">
                    <input type="radio" id="no" name="resolve" v-model="formTreatment.resolve" value="non">
                    <label for="no">Non</label>
                  </div>
                </div>
                <div id="procedure" class="mt-3">
                  <p class="font-weight-bolder">Type de l'intervention :</p>
                  <select name="typeInter" class="form-select" v-model="formTreatment.typeInter">
                    <option value="">Choisissez un type d'intervention</option>
                    <option v-for="intervention in interventions" :key="intervention.id_type_intervention" :value="intervention.id_type_intervention">
                      {{firstLetterUppercase(intervention.type_intervention)}}
                    </option>
                  </select>
                  <b v-if="formTreatment.errors.typeInter" class="text-danger">{{formTreatment.errors.typeInter}}</b>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col">
                <b-button type="submit">Traiter</b-button>
              </div>
            </div>
          </form>
        </div>
        <div id="cruce" v-on:click="hideFormTreatment">
          <a type="button" class="close text-danger" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
    </div>
  </div>
</template>

<script>
import Header from "../Component/Header.vue";

export default {
  name: "infoBilletStaff",
  components: {
    Header,
  },
  data() {
    return {
      deconnexion: "Deconnexion",
      title: "Billet ",
      laDate: this.date,
      connectedUser: this.connectedUser,
      form: this.$inertia.form({
        machine: this.billet.numero_machine ?? "",
        descr: this.billet.description_probleme ?? "",
        importance: this.billet.qualification_urgence ?? "",
        typeprob: this.billet.probleme?.id_probleme ?? "",
        datedebut: this.billet.date_enregistrement,
        datefin: this.billet.date_fin ?? "",
        pjbillet: this.billet.piecejointe ?? ""
      }),
      formOperateur : this.$inertia.form({
        operateur : '',
      }),
      formTreatment: this.$inertia.form({
        commentaire: '',
        resolve: '',
        typeInter: ''
      })
    };
  },
  props: {
    billet: {
      type: Object,
      defaultValue() {
        return {};
      },
    },
    problemes: {
      type: Array,
      defaultValue() {
        return Array;
      },
    },
    date: {
        type: String,
        defaultValue() {
            return String;
        }
    },
    connectedUser :{
      type : String,
    },
    operateurs: {
      type: Array,
      defaultValue() {
        return Array;
      },
    },
    interventions: {
      type: Array,
      defaultValue() {
        return Array;
      }
    }
  },
  methods: {
    firstLetterUppercase: function (s) {
      return s[0].toUpperCase() + s.slice(1);
    },
    changeButton: function() {
      let button = document.querySelector("#valider");
      if(button != null)
        button.classList.add('d-none');

      let buttonModif = document.querySelector('#modifier');
      buttonModif.classList.remove('d-none');

    },
    displayFormOperateur: function(){
      const div = document.querySelector("#divAAfficher");
      div.classList.remove('d-none');
    },
    hideFormOperateur: function(){
      const div = document.querySelector("#divAAfficher");
      div.classList.add('d-none');
    },
    displayFormTreatment: function() {
      const div = document.querySelector('#divformtreatment');
      div.classList.remove('d-none');
    },
    hideFormTreatment: function(){
      const div = document.querySelector("#divformtreatment");
      div.classList.add('d-none');
    },
  },
  watch: {
    numMachine: {
      immediate: true,
      handler() {
        this.form.machine = this.billet.numero_machine;
      },
    },
    description: {
      immediate: true,
      handler() {
        this.form.machine = this.billet.description_probleme;
      },
    },
    importanceQaulif: {
      immediate: true,
      handler() {
        this.form.machine = this.billet.qualification_urgence;
      },
    },
    problemeType: {
      immediate: true,
      handler() {
        this.form.machine = this.billet.probleme.id_probleme;
      },
    },
    piecejointe: {
      immediate: true,
      handler() {
        this.form.pjbillet = this.billet.piecejointe;
      },
    },
    datefin: {
      immediate: true,
      handler() {
        this.form.pjbillet = this.billet.datefin;
      },
    },
  },
};
</script>

<style scoped>
input:focus, textarea:focus {
  outline: none;
}
input:hover {
  cursor: unset;
}
#machine input {
  width: 100px;
}
#qualification input {
  width: 50px;
}
#date-depot input {
  width: 120px;
}
#date-fin input {
  width: fit-content;
}
#qualification,
#machine,
#isresolu {
  align-items: center;
}
input {
  border: solid 1px black;
}
#date-depot div,
#machine div,
#qualification div,
#date-fin div {
  font-size: 1.25rem;
  font-weight: 600;
}
label {
  margin-bottom: 0;
  margin-left: 0.5rem;
  font-size: 1.1em;
}
.container1 {
  margin-left: 10rem;
}
.container2 {
  margin-right: 10rem;
}
button {
  background-color: #8f7ac2;
  width: 200px;
  border-radius: 20px;
}
button a {
  text-decoration: none;
  color: #fff;
}
#pj img {
  width: 200px;
}
#overlay{
  position: absolute;
  top:50%;
  left: 50%;
  transform: translate(-50%,-50%);
  width: 50%;
  height: 60%;
}
#cruce{
  position: absolute;
  right: 2%;
  top: 2%;
}
</style>