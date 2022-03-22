<template>
    <div class="d-flex flex-column min-vh-100">
        <Header :title="title" :deconnexion="deconnexion" :connectedUser="connectedUser"></Header>
        <p v-if="tailleTableau == 0" class="text-center text-secondary mt-2">Vous n'avez aucune notification.....</p>
        <div class="mx-auto mt-4" v-if="tailleTableau >=1">
            <div class="list-group bg-light" role="alert" aria-live="assertive" aria-atomic="true" v-for="notif in user.notifications" :key="notif.id_notifcation">
            <div class="toast-header">
                <strong class="mr-auto font-weight-bold" v-if="!notif.is_read">Nouvelle Notification</strong>
                <strong class="mr-auto font-weight-light" v-if="notif.is_read">Ancienne Notification</strong>
                <small>{{new Date(notif.created_at).toLocaleDateString("fr")}}</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <Link :href="$route('effaceNotif',{notif : notif.id_notification})"><span aria-hidden="true">&times;</span></Link>
                </button>
            </div>
            <div class="toast-body">
                {{notif.libelle_notif}}
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

    name :"Notification",
    components: {
        Header,
        Footer
    },
    data(){
        return{
            deconnexion : "Deconnexion",
            title : "Notification",
            date : new Date()
        }
    },
    props :{
        user :{
            type : Object,
        },
        connectedUser :{
            type : String,
        },
        tailleTableau:{
           
        }
    } 
}
</script>
