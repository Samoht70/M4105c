<template>
    <div class="d-flex flex-column min-vh-100">
        <Header :title="title" :deconnexion="deconnexion" :connectedUser="connectedUser"></Header>

        <div class="container mt-3">
            <div class="row">
                <div class="col-6 p-2">
                    <div class="card">
                        <div class="card-header"><h5>Voir tous mes billets en cours</h5></div>
                        <div class="card-body">
                            <p class="card-text">Vos billets assignés sont ici</p>
                            <Link :href="$route('billetsStaff.view')" class="btn btn-primary">Voir mes billets</Link>
                        </div>
                    </div>
                </div>
                <div class="col-6 p-2">
                    <div class="card" v-if="connectedUser == 'responsable'">
                        <div class="card-header"><h5>Voir tous les billets sans opérateur</h5></div>
                        <div class="card-body">
                            <p class="card-text">Vos billets assignés sont ici</p>
                            <Link :href="$route('billet_sans_operateur.view')" class="btn btn-primary">Voir mes billets</Link>
                        </div>
                    </div>
                </div>
                <div class="col-6 p-2">
                    <div class="card" v-if="connectedUser == 'responsable'">
                        <div class="card-header"><h5>Voir les statistiques</h5></div>
                        <div class="card-body">
                            <p class="card-text">Les statistiques sont ici</p>
                            <Link :href="$route('stats.view')" class="btn btn-primary">Voir les statistiques</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer></Footer>
    </div>
</template>

<script>
import Header from '../Component/Header.vue'
import Footer from '../Component/Footer.vue'

export default {

    name :"HomeStaff",
    components: {
        Header,
        Footer
    },
    data(){
        return{
            deconnexion : "Deconnexion",
            title : "Bonjour, "+this.user.prenom+" "+this.user.nom,
        }
    },
    props :{
        user :{
            type : Object,
        },
        connectedUser :{
            type : String,
        }
    } 
}
</script>
