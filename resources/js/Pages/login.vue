<template>

  <div class="d-flex flex-column min-vh-100 bg">
    <Header :title="title" :connectedUser="connectedUser"></Header>
    <form class="coin" @submit.prevent="form.post($route('login'))">
      <div class="d-flex flex-column justify-content-center align-items-center mb-4">
        <label for="email" class="mb-2">Email</label>
        <input type="text" name="email" id="email" v-model="form.email" />
        <b v-if="form.errors.email" class="text-danger">{{
          form.errors.email
        }}</b>
      </div>

      <div class="d-flex flex-column justify-content-center align-items-center mb-5">
        <label for="password" class="mb-2">Mot de passe</label>
        <input
          type="password"
          name="password"
          id="password"
          v-model="form.password"
        />
        <b v-if="form.errors.password" class="text-danger">{{
          form.errors.password
        }}</b>
      </div>

      <b-button type="submit" :disabled="form.processing">
        Connexion<b-spinner small v-if="form.processing" class="ml-2"></b-spinner>
      </b-button>
    </form>

    <Footer></Footer>
  </div>
 
</template>

<script>
import Header from "../Component/Header.vue"
import Footer from '../Component/Footer.vue'
export default {
  name: "Login",
  components: {
    Header,
    Footer
  },
  data() {
    return {
      title : "Bonjour",
      connectedUser : null,
      form: this.$inertia.form({
        email: "",
        password: "",
      }),
    };
  },
};
</script>

<style scoped>
form {
  position: relative;
  left: 37.5vw;
  top: 20vh;
  display: flex;
  flex-direction: column;
  width: 25vw;
  justify-content: center;
  align-items: center;
  padding: 1rem;
}

button {
  background-color: #8F7AC2;
  width: 200px;
  border-radius: 20px;
}
#header {
  background-color: #8f7ac2;
}

.coin{
  background-color: #f0ebe8;
}

.bg{
  background-image: url("https://www.wallpaperflare.com/static/198/774/447/red-background-green-red-blue-wallpaper.jpg");
}




/*#footer {
  background-color: #8f7ac2;
  height: 100px;
  position:absolute;
  bottom:0;
}*/
</style>
