<template>
  <div>
    <div class="header">
        <v-header></v-header>
    </div>
    <div class="contain">
        <spin v-if="loading"></spin>
        <div v-else-if="!loading && !not_found">
            <h3 class="uk-text-muted">Статистика</h3>
            <div>
                <ul uk-tab>
                    <li><a href="">Спринты</a></li>
                </ul>

                <ul class="uk-switcher uk-margin">
                    <li>
                        <div class="BySprints">
                            <Sprint-Stats-Card v-for="sprint in sprints"
                                :key="sprint.Sprint_id"
                                :Sprint_id="sprint.Sprint_id"
                                :Sprint_Name="sprint.Sprint_Name"
                                :User_Name="sprint.User_Name"
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
import SprintStatsCard from '../elements/SprintStatsCard.vue';
import axios from 'axios';

export default {
        components: {
            Header, Spin, SprintStatsCard
        },
        data: () => ({
            loading: false,
            not_found: false,
            sprints: [],
        }),
        mounted() {
            this.loadSprints();
        },
        computed: {
            User_id() { return this.$store.getters.GetID }
        },
        created() {
            console.log("logged in: " + this.$store.getters.isLoggedIn);
            if (this.$store.getters.isLoggedIn === false) {
                this.$router.push('/');
            };
        },
        methods: {
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
            }
        }
}
</script>

<style>

</style>