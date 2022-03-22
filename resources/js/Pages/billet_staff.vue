<template>
    <div class="d-flex flex-column min-vh-100">
        <Header :title="title" :deconnexion="deconnexion" :connectedUser="connectedUser"></Header>
        <p class="text-center text-secondary mt-2" v-if="tailleTableau == 0">Vous n'avez aucun billet en cours...</p>

        <div v-if="tailleTableau >= 1" class="d-flex">
        
                <div class="filtres col-2 d-flex flex-column p-0 minifiltres ml-3">
                    <h5 id="titre">Filtrer vos billets</h5>
                    <div>
                        <label>Nom :</label>
                        <input type="text" v-model="saisie">
                    </div>
                    <div>
                        <label id="ferme" for="ferme">Fermés :</label>
                        <input type="checkbox" name="ferme" id="ferme" v-model="checkedValueFerme" value="true">
                    </div>
                    <div>
                        <label for="en_cours">En cours :</label>
                        <input type="checkbox" name="en_cours" id="en_cours" v-model="checkedValueEncours" value="false">
                    </div>    
                    <div>
                        <label for="qualif">Urgence :</label>
                        <select name="qualif" id="qualif" v-model="urgence">
                            <option value="[1,2,3,4,5,6,7,8,9,10]">---</option>
                            <option value="[8,9,10]">Très urgent (de 8 à 10)</option>
                            <option value="[4,5,6,7]">Urgent (de 4 à 7)</option>
                            <option value="[1,2,3]">Pas urgent (de 1 à 3)</option>
                        </select>
                    </div>
                    <div>
                        <label for="date_billet"> Date du billet</label>
                        <input type="date" name="date_billet" id="date_billet" v-model="date">
                    </div>
                </div>

        </div>
       
                <table class="mt-4 mx-auto col-9 tableau">
                    <thead>
                        <tr class="text-center">
                        <th>Numéro billet</th>
                            <th>Numéro machine</th>
                            <th>Qualification</th>
                            <th>Date du billet</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="billet in Filter" :key="billet.id_billet" class="text-left ligne">
                            <td class="ml-5">{{billet.id_billet}}</td>
                            <td class="ml-5">{{billet.numero_machine}}</td>
                            <td class="ml-5">{{billet.qualification_urgence}}</td>
                            <td class="ml-5">{{new Date(billet.date_enregistrement).toLocaleDateString("fr")}}</td>
                            <td class="text-center h-25"> <Link :href="$route('infoBilletStaff.view', {billet: billet.id_billet})">Voir plus</Link> </td>
                        </tr>
                    </tbody>      
                </table>
        <Footer></Footer>
    </div>
</template>

<script>
import Header from '../Component/Header.vue'
import Footer from '../Component/Footer.vue'

export default {
    name: "billetStaff",
    components: {
        Header,
        Footer
    },
    data(){
        return{
            deconnexion : "Deconnexion",
            title : "Vos billets en cours",
            tailleTableau : this.allBillets.length,
            table : this.allBillets,
            saisie: '',
            checkedValueFerme: '',
            checkedValueEncours:'',
            date:'',
            urgence:[1,2,3,4,5,6,7,8,9,10]
        }
    },
    props: {
        allBillets: {
            type: Array,
            defaultValue() {
                return [];
            },
        },
        connectedUser :{
            type : String,
        }
    },
    computed:{
        Filter(){
            
            return this.table.filter(billet => 
            (billet.demandeur.nom.toLowerCase().includes(this.saisie.toLowerCase()) ||
            billet.demandeur.prenom.toLowerCase().includes(this.saisie.toLowerCase()) ||
            `${billet.demandeur.nom + billet.demandeur.prenom}`.toLowerCase().replace(/\s/g, "").includes(this.saisie.toLowerCase().replace(/\s/g, "")) ||
            `${billet.demandeur.prenom + billet.demandeur.nom}`.toLowerCase().replace(/\s/g, "").includes(this.saisie.toLowerCase().replace(/\s/g, ""))) &&
            (billet.isclose == this.checkedValueFerme || billet.isclose == !this.checkedValueEncours) &&
            (billet.date_enregistrement.includes(this.date) &&
            (this.urgence.includes(billet.qualification_urgence))));

        }

    }
}
</script>

<style scoped>
    table {
        border-collapse: collapse;
    }
    th {
        border: solid 1px black;
        padding: 0.7rem;
        width: 12vw;
    }
    td {
        font-size: 1.2em;
        font-weight: 600;
        border: solid 1px black;
        padding: 1rem;
    }
    td a {
        background-color: #8f7ac2;
        border-radius: 20px;
        color: white;
        text-decoration: none;
        padding: 0.5rem 1.5rem 0.5rem 1.5rem;
    }
    .filtres{
        margin-top: 3em;
        
    }
    .minifiltres{
        
        background-color: lightgray;
    }
    #titre{
        margin-bottom: 2em;
    }
    #ferme{
        margin-top: 2em;
    }
    .tableau{
        position: absolute;
        left: 20em;
        top: 10em;
    }
</style>