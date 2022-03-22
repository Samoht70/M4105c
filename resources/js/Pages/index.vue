<template>
  <div class="d-flex flex-column min-vh-100">
    <Header :deconnexion="deconnexion" :title="title" :connectedUser="connectedUser"></Header>
    
    <div class="container mt-3">
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header"><h5>Déposez un billet</h5></div>
            <div class="card-body">
              <p class="card-text">Déposez votre billet en quelques clics</p>
              <Link :href="$route('depotbillet.view')" class="btn btn-primary">Déposer billet</Link>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header"><h5>Voir mes billets en attentes</h5></div>
            <div class="card-body">
              <p class="card-text">Vos billets en cours de traitement se trouvent ici</p>
              <Link :href="$route('billet_attente')" class="btn btn-primary">Voir</Link>
            </div>
            </div>
          </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-6">
            <div class="card">
              <div class="card-header"><h5>Voir mes notifications</h5></div>
              <div class="card-body">
                <p class="card-text">Vos notifications se trouvent ici</p>
                <Link :href="$route('notification_attente')" class="btn btn-primary">Voir</Link> 
              </div>
              </div>
          </div>
        </div>
      </div>
      <Footer></Footer>
    </div>
</template>

<script>
import List from "../Component/List.vue";
import Header from "../Component/Header.vue"
import Footer from '../Component/Footer.vue'
export default {
  name: "Index",
  components: {
    Header,
    Footer
  },
  data() {
    return {
      deconnexion: "Deconnexion",
      title: "Accueil",
      connectedUser: this.connectedUser
    };
  },
  props :{
        connectedUser :{
            type : String,
        }
    } 
};
</script>

<style scoped>
.list {
  border: solid 2px black;
  border-radius: 1rem;
  margin: 1rem;
}
</style>