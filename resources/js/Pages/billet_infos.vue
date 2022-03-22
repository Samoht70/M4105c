<template>
  <div class="d-flex flex-column min-vh-100">
    <Header
      :title="title + billet.id_billet"
      :deconnexion="deconnexion"
      :connectedUser="connectedUser"
    ></Header>
    <form
      @submit.prevent="form.post($route('ModificationBillet', {billet: billet.id_billet}))"
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
              name="machine"
              v-model="form.machine"
              class="font-weight-bold text-center"
              v-if="billet.isclose == false"
            />
            <input
              type="text"
              name="machine"
              v-model="form.machine"
              class="font-weight-bold text-center"
              v-if="billet.isclose == true"
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
              v-if="billet.isclose == false"
            ></textarea>
            <textarea
              name="descr"
              id="descr"
              cols="30"
              rows="3"
              v-model="form.descr"
              v-if="billet.isclose == true"
              readonly
            ></textarea>
          </div>
          <div id="qualification" class="d-flex mb-5">
            <div class="mr-2">Importance du billet</div>
            <input
              type="text"
              name="importance"
              v-model="form.importance"
              class="font-weight-bold text-center"
              v-if="billet.isclose == false"
            />
            <input
              type="text"
              name="importance"
              v-model="form.importance"
              class="font-weight-bold text-center"
              v-if="billet.isclose == true"
              readonly
            />
          </div>
          <div id="pj">
            <p class="mr-2">Pièces jointes</p>
            <img v-if="billet.piecejointe != null" :src="'/pjBillet/' + billet.piecejointe" alt="Image du problème" />
            <input type="file" name="pjbillet" id="pjbillet" @input="form.pjbillet = $event.target.files[0]" v-if="billet.isclose == false">
            <b v-if="form.errors.pjbillet" class="text-danger">{{form.errors.pjbillet}}</b>
          </div>
        </div>

        <div
          id="container"
          class="d-flex flex-column align-items-center container2"
        >
          <div id="prequalif" class="mb-5">
            <p class="h5">Pré-qualification du type de problème</p>
            <select name="typeprob" id="typeprob" v-model="form.typeprob" v-if="billet.isclose == false">
              <option value="">Choisir un type de problème</option>
              <option
                v-for="probleme in allProblemes"
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
            <div class="mr-3">Date de dépôt du billet :</div>
            <input
              type="text"
              name="datedebut"
              v-model="billet.date_enregistrement"
              class="text-center font-weight-bold"
              readonly
            />
          </div>
          <div id="date-fin" class="d-flex align-items-center mb-5">
            <div class="mr-3">Date de fin prévue du billet :</div>
            <input
              type="text"
              name="datefin"
              :value="
                billet.date_fin != null
                  ? billet.date_fin
                  : 'Probleme pas encore résolu'
              "
              class="text-center font-weight-bold"
              readonly
            />
          </div>
        </div>
      </div>
      <div id="submit" class="mt-5 text-center">
        <b-button class="mr-3" id="valider" type="submit" v-if="billet.isclose == false">
          Modifier le billet
          <b-spinner small v-if="form.processing" class="ml-2"></b-spinner>
        </b-button>
        <b-button class="quitter">
          <Link :href="$route('billet_attente')" class="">Quitter le billet</Link>
        </b-button>
      </div>
    </form>
    <div class="text-center mt-3" v-if="billet.isclose == true">
      <h2 class="text-success">Le billet est fermé</h2>
    </div>
  </div>
</template>

<script>
import Header from "../Component/Header.vue";

export default {
  name: "infosbillet",
  components: {
    Header,
  },
  data() {
    return {
      deconnexion: "Deconnexion",
      title: "Billet ",
      connectedUser : this.connectedUser,
      form: this.$inertia.form({
        machine: this.billet.numero_machine ?? "",
        descr: this.billet.description_probleme ?? "",
        importance: this.billet.qualification_urgence ?? "",
        typeprob: this.billet.probleme?.id_probleme ?? "",
        pjbillet: this.billet.piecejointe ?? ""
      }),
    };
  },
  props: {
    billet: {
      type: Object,
      defaultValue() {
        return {};
      },
    },
    allProblemes: {
      type: Array[Object],
      defaultValue() {
        return Array[Object];
      },
    },
    connectedUser: {
      type :String,
    }
  },
  methods: {
    firstLetterUppercase: function (s) {
      return s[0].toUpperCase() + s.slice(1);
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
  },
};
</script>

<style scoped>
input:focus {
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
</style>