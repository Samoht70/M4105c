<template>
    <div class="d-flex flex-column min-vh-100">
        <Header :title="title" :deconnexion="deconnexion" :connectedUser="connectedUser"></Header>
        <p class="text-center text-secondary mt-2" v-if="tailleTableau == 0">Il n'y a pas de billet sans opérateur...</p>
        <table class="mt-4 mx-auto" v-if="tailleTableau >= 1">
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
                <tr class="text-left">
                    <tr v-for="billet in billets" :key="billet.id_billet" class="text-left">
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
            title : "Billets en attente d'opérateur",
            tailleTableau : this.billets.length,
            connectedUser: this.connectedUser
        }
    },
    props: {
        billets: {
            type: Array,
            defaultValue() {
                return [];
            },
        },
        connectedUser :{
            type : String,
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
</style>