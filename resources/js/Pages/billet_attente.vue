<template>
    <div class="d-flex flex-column min-vh-100">
        <Header :title="title" :deconnexion="deconnexion" :connectedUser="connectedUser"></Header>
        <div class="d-flex justify-content-center align-items-center mt-3">
            <button class="btn btn-bg mx-2" type="button" v-on:click="loadAll">Voir tous les billets</button>
            <button class="btn btn-bg mx-2" type="button" v-on:click="loadCurrent">Billets en cours</button>
            <button class="btn btn-bg mx-2" type="button" v-on:click="loadClosed">Billets fermés</button>
        </div>
        <table class="mt-4 mx-auto">
            <thead>
                <tr class="text-center">
                    <th>Numéro billet</th>
                    <th>Numéro machine</th>
                    <th>Qualification</th>
                    <th>Date du billet</th>
                    <th>Voir plus</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="billet in table" :key="billet.id_billet" class="text-left">
                    <td class="ml-5">{{billet.id_billet}}</td>
                    <td class="ml-5">{{billet.numero_machine}}</td>
                    <td class="ml-5">{{billet.qualification_urgence}}</td>
                    <td class="ml-5">{{new Date(billet.date_enregistrement).toLocaleDateString("fr")}}</td>
                    <td class="text-center h-25"> <Link :href="$route('infos_billet', {billet: billet.id_billet})">Voir plus</Link> </td>
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
    name: "attentebillet",
    components: {
        Header,
        Footer
    },
    data(){
        return{
            deconnexion : "Deconnexion",
            title : "Billet en attente",
            table : this.allBillets,
            connectedUser : this.connectedUser
        }
    },
    props: {
        allBillets: {
            type: Array,
            defaultValue() {
                return [];
            },
        },
        currentBillets :{
            type: Array,
            defaultValue() {
                return [];
            },
        },
        closedBillets : {
            type: Array,
            defaultValue() {
                return [];
            }, 
        },
        connectedUser : {
            type: String,
        }
    },
    methods : {
        loadAll: function(){
            this.table = this.allBillets;
        },
        loadCurrent: function(){
            this.table = this.currentBillets;
        },
        loadClosed: function(){
            this.table = this.closedBillets;
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
    .btn-bg{
        background-color: #8f7ac2;
        color: white;
    }
</style>