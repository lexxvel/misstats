<template>
  <div>
    <div class="header">
        <v-header></v-header>
    </div>
    <div class="contain">
        <spin v-if="loading"></spin>
        <div v-else-if="!loading && !not_found">
            <h3 class="uk-text-muted">Графики</h3>
            <div>
                <ul uk-tab>
                    <li><a href="" @click="getTopFiveFailPersons">Топ 5 косячников</a></li>
                    <li><a href="" @click="getTopFiveFailCauses">Топ 5 причин задержки</a></li>
                </ul>

                <ul class="uk-switcher uk-margin">
                    <li>
                        <div class="PersonsTop">
                            <PieChart
                                :chartCountData="arrPersonsFailsTopFive"
                                :chartLabelsData="arrPersonsFioTopFive"
                            />
                        </div>
                    </li>
                    <li>
                        <div class="CausesTop">
                            <PieChart
                                :chartCountData="arrCausesCountTopFive"
                                :chartLabelsData="arrCausesLabelsTopFive"
                            />
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Header from '../elements/Header.vue'
import Spin from '../elements/Spin.vue';
import ItemCard from '../elements/ItemCard.vue';
import PieChart from '../elements/Pie.vue'
import axios from 'axios';

export default {
        components: {
            Header, Spin, ItemCard, PieChart
        },
        data: () => ({
            loading: false,
            not_found: false,
            persons: [],
            causes: [],
            arrPersonsFioTopFive: [],
            arrPersonsFailsTopFive: [],
            arrCausesLabelsTopFive: [],
            arrCausesCountTopFive: []
        }),
        mounted() {
            this.getTopFiveFailPersons();
        },
        created() {
            /*console.log("logged in: " + this.$store.getters.isLoggedIn);
            console.log("role: " + $cookies.get('role_id'));
            if (this.$store.getters.isLoggedIn === false || this.$store.getters.GetRole !== "2") {
            this.$router.push('/');
            };*/
        },
        methods: {
            getTopFiveFailPersons() {
                axios.get('/api/persons/top/topFiveFailPersons')
                .then(res => {
                    this.persons = res.data;
                    if (this.arrPersonsFioTopFive == 0 && this.arrPersonsFailsTopFive == 0) {
                        for (const el of this.persons) {
                        this.arrPersonsFioTopFive.push(el.Person_Fullname);
                        this.arrPersonsFailsTopFive.push(el.Person_Failcount);
                        }
                    }
                    setTimeout(()=> {
                        this.loading = false;
                    }, 100)                    
                })
                .catch(err => {
                    this.not_found = true;
                })
            },
            getTopFiveFailCauses() {
                axios.get('/api/causes/top/topFiveFailCauses')
                .then(res => {
                    this.causes = res.data;
                    if (this.arrCausesLabelsTopFive == 0 && this.arrCausesCountTopFive == 0) {
                        for (const el of this.causes) {
                        this.arrCausesLabelsTopFive.push(el.Cause_Name);
                        this.arrCausesCountTopFive.push(el.Cause_Failcount);
                        }
                    }
                    setTimeout(()=> {
                        this.loading = false;
                    }, 100)                    
                })
                .catch(err => {
                    this.not_found = true;
                })
            }
        }
}
</script>

<style>

</style>