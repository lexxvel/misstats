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
                    <li><a href="" @click="loadSprints">Топ 5 причин задержки По спринтам</a></li>
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
                    <li>
                        <div class="BySprints">
                            <span class="uk-label labelMax">Выберите спринт</span>
                            <select v-model="form.Sprint_id" class="uk-select" id="form-horizontal-select">
                                <options v-for="sprint in sprints"
                                :key="sprint.Sprint_id"
                                :Option="sprint.Sprint_Name"
                                :id="sprint.Sprint_id"
                                />
                            </select>
                            <button class="uk-button uk-button-primary" @click="findStatsBySprint">Найти</button>

                            <PieChart v-if="dataBySprintLoaded"
                                :chartCountData="arrCausesBySprintsCounts"
                                :chartLabelsData="arrCausesBySprintsLabels"
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
import PieChart from '../elements/Pie.vue'
import Options from '../elements/Options.vue';
import axios from 'axios';

export default {
        components: {
            Header, Spin, PieChart, Options
        },
        data: () => ({
            loading: false,
            not_found: false,
            dataBySprintLoaded: false,
            persons: [],
            causes: [],
            sprints: [],
            arrPersonsFioTopFive: [],
            arrPersonsFailsTopFive: [],
            arrCausesLabelsTopFive: [],
            arrCausesCountTopFive: [],
            form: {
                Sprint_id: ""
            },
            arrCausesBySprints: [],
            arrCausesBySprintsLabels: [],
            arrCausesBySprintsCounts: []
        }),
        mounted() {
            if (this.$store.getters.isLoggedIn === false) {
                this.$router.push('/');
            } else {
                this.getTopFiveFailPersons();
            }
        },
        computed: {
            User_id() { return this.$store.getters.GetID }
        },
        created() {
            console.log("logged in: " + this.$store.getters.isLoggedIn);
            if (this.$store.getters.isLoggedIn === false || this.$store.getters.GetRole === '1') {
            this.$router.push('/');
            };
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
            },
            loadSprints() {
                axios.post('/api/sprints', {User_id: this.User_id})
                    .then(res => {
                        if (res.data.status == false || res.data == "" || res.data == null || !res.data) {
                            setTimeout(() => {
                                this.loading = false;
                            },  50)
                            this.sprints = [];
                            this.not_found = true;
                        } else {
                            this.sprints = res.data;
                            this.not_found = false;
                            setTimeout(() => {
                                this.loading = false;
                            },  50)
                        }
                    })
            },
            findStatsBySprint() {
                this.dataBySprintLoaded = false;
                this.arrCausesBySprints = [];
                this.arrCausesBySprintsLabels = [];
                this.arrCausesBySprintsCounts = [];
                axios.post('/api/sprintCausesLink/bySprint', {Sprint_id: this.form.Sprint_id})
                .then(res => {
                    if (res.data.status == false) {
                        this.dataBySprintLoaded = false;
                    } else {
                        this.arrCausesBySprints = res.data;
                        if (this.arrCausesBySprintsLabels == 0 && this.arrCausesBySprintsCounts == 0) {
                            for (const el of this.arrCausesBySprints) {
                            this.arrCausesBySprintsLabels.push(el.Cause_Name);
                            this.arrCausesBySprintsCounts.push(el.Cause_Failcount);
                            }
                        }
                    this.dataBySprintLoaded = true;
                    }
                })
            }
        }
}
</script>

<style>

</style>