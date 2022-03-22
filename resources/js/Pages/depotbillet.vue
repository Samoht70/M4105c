<template>
    <div class="d-flex flex-column min-vh-100">
        <Header :title="title" :deconnexion="deconnexion" :connectedUser="connectedUser"></Header>

        
        <form @submit.prevent="form.post($route('ValidationBillet'))">


        <div id="part1">


        <div class="d-flex justify-content-center divtext">
            <div class="num">1</div>
            <p class="numtext" >Numéro de la machine *</p>  
        </div>
        

        <div class="d-flex justify-content-center">
            <div class="mb-3 col-6 ">
                <input type="text" class="form-control " placeholder="XXXX" id="num_machine" name="num_machine" v-model="form.num_machine">
                <b v-if="form.errors.num_machine" class="text-danger">{{form.errors.num_machine}}</b> 
            </div> 
        </div>


        <div class="d-flex justify-content-center divtext2">
            <div class="num">2</div>
            <p class="numtext">Description *</p>
        </div>


        <div class="d-flex justify-content-center">
            <div class="mb-3 col-6">
                <input type="text" class="form-control" placeholder="Description..." id="description" name="description" v-model="form.description">
                <b v-if="form.errors.description" class="text-danger">{{form.errors.description}}</b> 
            </div>            
        </div>


        <div class="d-flex justify-content-center">
            <b-button class="button" v-on:click="greet">Suivant
            </b-button>            
        </div>


        </div>


        <!--Formulaire 2-->


        <div id="part2" class="hidden">

        <div class="d-flex justify-content-start">
            <b-button class="button" v-on:click="greet_back">Retour
            </b-button>            
        </div>

        <div>

        <div class="gauche" style="float: left; width">

       
        <div class="trois">

        <div class="divtext3">
            <div class="num">3</div>
            <p class="numtext2">Qualification de votre problème *</p>
        </div>

         
            <div>une échelle de 1 à 10 </div>
            <select name="pets" id="qualification" v-model="form.pets">
                <option v-for="item in items" :key="item.Valeur">
                    {{item.Valeur}}
                </option>   
            </select> 
            <b v-if="form.errors.pets" class="text-danger">{{form.errors.pets}}</b>          
        </div>


        <div class="quatre divtext3">
            <div class="num">4</div>
            <p class="numtext2">Pré-qualification</p>
        </div>

         <div class="quatre">
            <div>
              <select name="pre_qual" id="prequal" v-model="form.pre_qual">
                <option value="">---------</option>
                <option v-for="item in allProblemes" :key="item.id_probleme" v-bind:value="item.id_probleme">
                    {{item.type_probleme.slice(0,1).toUpperCase()+item.type_probleme.slice(1)}}
                </option>   
            </select>    
            </div>            
        </div>

        </div>

        <div class="droite" style="float: right;">

        <div class="cinq divtext3">
            <div class="num">5</div>
            <p class="numtext2">Déposer des pièces-jointes</p>
        </div>

        <div class="">
            <input type="file" id="fichier" name="fichier" @input="form.fichier = $event.target.files[0]">
            <b v-if="form.errors.fichier" class="text-danger">{{form.errors.fichier}}</b>
        </div>

        </div>

        <div class="valider">
            <b-button class="button2" type="submit">Valider</b-button>            
        </div>


        </div>


        
        </div>
    <!--Fin Formulaire-->

    </form>
    <Footer></Footer>
    </div>
    
</template>

<script>
import Header from '../Component/Header.vue'
import Footer from '../Component/Footer.vue'

export default {
    name: "depotbillet",
    components: {
        Header,
        Footer
    },
    data(){
        return{
             form: this.$inertia.form({
                 num_machine: "",
                description: "",
                pets: "",
                date:"",
                pre_qual:"",
                fichier:"",
        
      }),
            connectedUser: this.connectedUser,
            deconnexion : "Deconnexion",
            title : "Déposer un billet",
            items: [
               { Valeur: '1' },
               { Valeur: '2' },
               { Valeur: '3' },
               { Valeur: '4' },
               { Valeur: '5' },
               { Valeur: '6' },
               { Valeur: '7' },
               { Valeur: '8' },
               { Valeur: '9' },
               { Valeur: '10' }
            ],
        }
    },
    props : {
        allProblemes :{
            type : Array,
            defaultValue(){
                return [];
            },
        },
        connectedUser: {
            type : String,
        }
    },
    methods: {
    greet: function () {

        const part1 = document.querySelector("#part1");
        const part2 = document.querySelector("#part2");

        if(part1.classList.contains("hidden")){
            part1.classList.remove("hidden");
            part2.classList.add("hidden");
        }

        if(part2.classList.contains("hidden")){
            part2.classList.remove("hidden");
            part1.classList.add("hidden");
        }
    },


    greet_back: function () {
        
        const part1 = document.querySelector("#part1");
        const part2 = document.querySelector("#part2");
 
        if(part1.classList.contains("hidden")){
            part1.classList.remove("hidden");
            part2.classList.add("hidden");
        }

    },

  }
}

</script>



<style scoped>
.num{
    font-size: 30px;
    background-color: #8F7AC2;
    color: white;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    text-align: center;
 
}

.numtext{
       margin-left: 5%;
       margin-top: 3%;
   
}

.numtext2{
       margin-left: 2%;
       margin-top: 1%;
   
}

.divtext{
    width: 20%;
    margin-left: 40%;
    margin-top: 8%;
    margin-bottom: 2%;
}

.divtext2{
    width: 20%;
    margin-left: 38%;
    margin-top: 8%;
    margin-bottom: 2%;
}

.divtext3{
   
    margin-top: 8%;
    margin-bottom: 2%;
}

.button{
    margin-top: 50px;
    font-size: 20px;
    border-radius: 50px;
    background-color: #8F7AC2;
    color:white;
    width: 10%;
    height: 5,5vh;
    margin-bottom: 100px;
}

.button2{
    margin-top: 400px;
    font-size: 20px;
    border-radius: 50px;
    background-color: #8F7AC2;
    color:white;
    width: 10%;
    height: 5,5vh;
    margin-bottom: 50px;
}


.nt3{
    margin-left: 10%;
    margin-top: -2%;
}

.pnt3{
    margin-left: 10%;
    margin-top: 2%;
}

.hidden{
    display: none!important;
}

.gauche{
    margin-left: 25em;
    padding-left: -10em;
}

.droite{
    margin-right: 20em;
}

.trois{
    margin-bottom: 50px;
}

.quatre{
  
}

.valider{

}


</style>