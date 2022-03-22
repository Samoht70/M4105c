<template>
    <div class="d-flex flex-column min-vh-100">
        <head>
            <link rel="stylesheet" href="https://unpkg.com/charts.css/dist/charts.min.css">
        </head>
        <Header :title="title" :deconnexion="deconnexion" :connectedUser="connectedUser"></Header>

        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h3>Efficacité des opérateurs</h3>
                    <div class="chart">
                        <table id="my-chart" class="charts-css column ">
                            <tr v-for="(nbJour, idBillet) in dateMoyTheo" :key="idBillet">
                                <th>Billet {{idBillet}}</th>
                                <td>{{nbJour}}j de temps théorique de résolution</td>
                                <td>{{dateMoyReel[idBillet]}}j de temps réel de résolution</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <Footer></Footer>
    </div>
</template>

<script>
import Header from "../Component/Header.vue";
import Footer from "../Component/Footer.vue";

export default {
    name: 'statsStaff',
    component: {
        Header,
        Footer
    },
    data() {
        return {
            deconnexion: "Deconnexion",
            title: "Statistiques des billets",
            connectedUser: this.connectedUser,
        }
    },
    props: {
        connectedUser :{
            type : String,
        },
        dateMoyTheo: {
            type: Object,
            defaultValue() {
                return {};
            }
        },
        dateMoyReel: {
            type: Object,
            defaultValue() {
                return {};
            }
        }
    }
}
</script>

<style scoped>
#my-chart.column {
  height: 200px;
  max-width: 300px;
  margin: 0 auto;
}
td {
    height: 20px;
}
</style>