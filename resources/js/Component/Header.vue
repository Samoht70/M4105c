<template>
  <div>
    <div id="header" class="d-flex align-items-center">
      <h1 class="mr-auto p-2 ml-2">
        <a class="pe-auto text-decoration-none text-white" v-if="connectedUser == 'responsable' || connectedUser == 'operateur'" href="/staff/home">HelpDesk</a>
        <a class="pe-auto text-decoration-none text-white" v-if="connectedUser == 'web'" href="/home">HelpDesk</a>
        <a class="pe-auto text-decoration-none text-white" href="#" v-if="connectedUser == null">HelpDesk</a>
      </h1>
      <h1 class="text-white mr-auto p-2">{{ title }}</h1>
      <h5 class="p-2 mr-2">
        <a class="pe-auto text-decoration-none text-white" href="/deconnexion">{{ deconnexion }}</a>
      </h5>
    </div>
  </div>
</template>

<script>
export default {
  name: "Header",
  props: {
    title: {
      type: String,
      required: true,
    },
    deconnexion: {
      type: String,
      require: true,
    },
    connectedUser: {
      type: String
    }
  },
};
</script>

<style scoped>
#header {
  background-color: #8f7ac2;
}
</style>