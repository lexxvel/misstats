<template>
  <div class="wrapper">
        <div class="header">
            <v-header></v-header>
        </div>
        <div class="sprintsWindow">
            <h3 class="uk-text-muted">Спринты</h3>
            <button id="modalBtn" class="uk-button uk-button-primary" href="#modal-addSprint-center" uk-toggle>Добавить</button>

            <spin v-if="loading"></spin>
            <div class="uk-grid" v-else-if="!loading && !not_found">
                    <sprint-card v-for="sprint in sprints"
                    :key="sprint.Sprint_id" 
                    :Sprint_Name="sprint.Sprint_Name"
                    :Sprint_UserId="sprint.Sprint_UserId"
                    :User_Name="sprint.User_Name"
                    />
            </div>


            <div id="modal-addSprint-center" class="uk-flex-top" uk-modal>
                <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                    <h3>Добавление спринта</h3>
                    <form class="add-sprint" @submit.prevent="addSprint" method="POST">
                        <fieldset class="uk-fieldset">
                            <div class="uk-margin">
                                <input required class="uk-input" v-model="form.Sprint_Name" type="text" placeholder="Название спринта, например Team Стационар - Спринт 22-22">
                            </div>
                            <button class="uk-button uk-button-default uk-modal-close" type="button" @click="clearAddSprintForm()">Отмена</button>
                            <button class="uk-button uk-button-primary" type="submit">Сохранить</button>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div uk-alert v-if="not_found">
                <h3>Спринты ещё не добавлены!</h3>
            </div>
        </div>
        <div class="footer">
            <footer-vue></footer-vue>
        </div>
  </div>
</template>

<script>
import Header from '../elements/Header.vue'
import FooterVue from '../elements/FooterBlock.vue'
import Spin from '../elements/Spin.vue';
import Options from '../elements/Options.vue';
import SprintCard from '../elements/SprintCard.vue'
import axios from 'axios';
export default {
 components: {
        Header, Spin, Options, SprintCard, FooterVue
    },
    data: () => ({
        loading: true,
        sprints: [],
        form: {
            Sprint_Name : ""
        },
        not_found: false,
        isLoggedIn: false
    }),
    mounted() {
        if (this.$store.getters.isLoggedIn === false) {
            this.$router.push('/');
        } else {
            this.loadSprints();
        } 
    },
    computed: {
        User_id() { return this.$store.getters.GetID }
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
        },
        addSprint: function () {
            axios.post('/api/sprints/add', {
                User_id: this.User_id,
                Sprint_Name: this.form.Sprint_Name,
                })
            .then(res => {
                if (res.data.status == true) {
                    UIkit.notification({message: res.data.message, status: 'success'});
                } else if (res.data.status == false ) {
                    UIkit.notification({message: res.data.message, status: 'danger'});
                } else {
                    UIkit.notification({message: "При добалении спринта произошла непредвиденная ошибка", status: 'danger'});
                }
            });
            UIkit.modal("#modal-addSprint-center").hide();
            this.clearAddSprintForm();
            this.loadSprints();
        },

        /**
         * Очистить данные формы
         */
        clearAddSprintForm(){
             this.form.Sprint_Name = ""
        }
    }
}
</script>

<style>
.sprintsWindow {
    display: block;
    min-height: 100%;
    height: auto;
}
</style>