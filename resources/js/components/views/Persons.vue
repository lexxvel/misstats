<template>
  <div class="wrapper">
        <div class="header">
            <v-header></v-header>
        </div>
        <div class="personsWindow">
            <h3 class="uk-text-muted">Пользователи</h3>
            <button id="modalBtn" class="uk-button uk-button-primary" href="#modal-addPerson-center" uk-toggle>Добавить</button>

            <spin v-if="loading"></spin>
            <div class="uk-grid" v-else-if="!loading && !not_found">
                    <person-card v-for="person in persons"
                    :key="person.Person_id" 
                    :Person_id="person.Person_id"
                    :Person_Fullname="person.Person_Fullname"
                    :Person_Email="person.Person_Email"
                    :Person_TableId="person.Person_TableId"
                    :Person_Failcount="person.Person_Failcount"
                    />
            </div>


            <div id="modal-addPerson-center" class="uk-flex-top" uk-modal>
                <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                    <h3>Добавление сотрудника</h3>
                    <form class="add-person" @submit.prevent="addPerson" method="POST">
                        <fieldset class="uk-fieldset">
                            <div class="uk-margin">
                                <input required class="uk-input" v-model="form.Person_Surname" type="text" placeholder="Фамилия сотрудника">
                            </div>
                            
                            <div class="uk-margin">
                                <input required class="uk-input" v-model="form.Person_Name" type="text" placeholder="Имя">
                            </div>

                            <div class="uk-margin">
                                <input required class="uk-input" v-model="form.Person_Secname" type="text" placeholder="Отчество">
                            </div>
                            
                            <div class="uk-margin">
                                <input required class="uk-input" v-model="form.Person_Email" type="email" placeholder="Email">
                            </div>

                            <div class="uk-margin">
                                <input class="uk-input" v-model="form.Person_TableId" type="text" placeholder="Табельный номер (Не обязательно)">
                            </div>

                            <button class="uk-button uk-button-default uk-modal-close" type="button" @click="clearAddTaskForm()">Отмена</button>
                            <button class="uk-button uk-button-primary" type="submit">Сохранить</button>
                        </fieldset>
                    </form>
                </div>
            </div>


            <div uk-alert v-if="not_found">
                <h3>Пользователи ещё не добавлены!</h3>
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
import PersonCard from '../elements/PersonCard.vue'
import axios from 'axios';
export default {
 components: {
        Header, Spin, Options, PersonCard, FooterVue
    },
    data: () => ({
        loading: true,
        persons: [],
        form: {
            Person_Surname : "",
            Person_Name : "",
            Person_Secname : "",
            Person_Email : "",
            Person_TableId : ""
        },
        not_found: false,
        isLoggedIn: false
    }),
    mounted() {
        if (this.$store.getters.isLoggedIn === false) {
            this.$router.push('/');
        }
        this.loadPersons();
    },
    methods: {
        loadPersons() {
            axios.get('/api/persons')
            .then(res => {
                if (res.data.status == false || res.data == "" || res.data == null || !res.data) {
                    setTimeout(() => {
                        this.loading = false;
                    },  50)
                    this.persons = [];
                    this.not_found = true;
                } else {
                    this.persons = res.data;
                    this.not_found = false;
                    setTimeout(() => {
                        this.loading = false;
                    },  50)
                }
            })
        },
        addPerson: function () {
            axios.post('/api/persons/add', {
                Person_Name: this.form.Person_Name,
                Person_Secname: this.form.Person_Secname,
                Person_Surname: this.form.Person_Surname,
                Person_Email: this.form.Person_Email,
                Person_TableId: this.form.Person_TableId
                })
            .then(res => {
                if (res.data.status == true) {
                    UIkit.notification({message: res.data.message, status: 'success'});
                } else if (res.data.status == false ) {
                    UIkit.notification({message: res.data.message, status: 'danger'});
                } else {
                    UIkit.notification({message: "При добалении пользователя произошла непредвиденная ошибка", status: 'danger'});
                }
            });
            UIkit.modal("#modal-addPerson-center").hide();
            this.clearAddTaskForm();
            this.loadPersons();
        },

        /**
         * Очистить данные формы
         */
        clearAddTaskForm(){
             this.form.Person_Surname = "";
             this.form.Person_Name = "";
             this.form.Person_Secname = "";
             this.form.Person_Email = "";
             this.form.Person_TableId = "";
        }
    }
}
</script>

<style>
.personsWindow {
    display: block;
    min-height: 100%;
    height: auto;
}
</style>