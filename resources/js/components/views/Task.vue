<template>
  <div>
    <div class="header">
        <v-header></v-header>
    </div>
    <div class="contain">
        <spin v-if="loading || causesIsEmpty || personsIsEmpty"></spin>
        <div v-if="!loading && !not_found && !causesIsEmpty && !personsIsEmpty">
        <h3>Редактирование задачи {{task.Task_Number}}</h3>
            <hr class="uk-divider-icon">
            <div class="TaskContain">
                <form class="edit-task" @submit.prevent="" method="POST">
                    <fieldset class="uk-fieldset"> 
                        
                        <div class="uk-margin">
                            <span class="uk-label labelMax">Плановое время</span>
                            <input required class="uk-input uk-form-width-large" v-if="task.Task_Plantime == null" v-model="form.Task_Plantime" type="text" placeholder="Планируемое время выполнения">
                            <input disabled class="uk-input uk-form-width-large" v-if="task.Task_Plantime !== null" v-model="task.Task_Plantime" type="text" placeholder="Планируемое время выполнения">
                        </div>

                        <hr class="uk-divider-icon">

                        <div class="uk-margin">
                            <span class="uk-label labelMax">Фактические трудозатраты</span>
                            <input required class="uk-input uk-form-width-large" v-if="task.Task_Facttime == null" v-model="form.Task_Facttime" type="text" placeholder="Фактические трудозатраты">
                            <input disabled class="uk-input uk-form-width-large" v-if="task.Task_Facttime !== null" v-model="task.Task_Facttime" type="text" placeholder="Фактические трудозатраты"> 
                        </div>

                        <hr class="uk-divider-icon">

                        <div class="uk-margin">
                            <span class="uk-label labelMax">Причина задержки</span>
                            <div v-if="task.Task_Failcause == 101 || task.Task_Failcause == null" class="uk-form-controls selectSmall">
                                <select v-model="form.Task_Failcause" class="uk-select selectSmall" id="form-horizontal-select">
                                    <options v-for="option in CauseOptions"
                                    :key="option.Cause_id"
                                    :Option="option.Cause_Name"
                                    />
                                </select>
                            </div>

                            <input disabled class="uk-input uk-form-width-large" v-if="task.Task_Failcause !== 101" v-model="task.Cause_Name" type="text" placeholder="Причина задержки">
                        </div>
                        <hr class="uk-divider-icon">
                        
                        <div class="uk-margin">
                            <span class="uk-label labelMax">Виновный</span>
                            
                            <div v-if="task.Task_Failperson == 101" class="uk-form-controls selectSmall">
                                <select v-model="form.Task_Failperson" class="uk-select selectSmall" id="form-horizontal-select">
                                    <options v-for="person in Persons"
                                    :key="person.Person_id"
                                    :Option="person.Person_Fullname"
                                    />
                                </select>
                            </div>
                            <input disabled class="uk-input uk-form-width-large" v-if="task.Task_Failperson !== 101" v-model="task.Person_Fullname" type="text" placeholder="Виновный">
                        </div>
                    </fieldset>
                </form>
                <button class="uk-button uk-button-danger" @click="goToIndex">Назад</button>
                <button class="uk-button uk-button-primary" @click="addTaskInfo">Сохранить</button>
                <button class="uk-button uk-button-primary" @click="addTaskInfoAndExit">Сохранить и выйти</button>
            </div>    
        </div>

        <div uk-alert v-if="not_found && !loading">
            <h3>Ошибка 404. Задача не найдена!  <a @click="goToIndex"> Вернуться на главную</a></h3>
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
import axios from 'axios';
export default {
 components: {
        Header, Spin, Options, FooterVue
    },
    data: () => ({
        loading: true,
        task: [],
        form: {
            Task_Plantime : "",
            Task_Facttime : "",
            Task_Failcause : "",
            Task_Failperson : ""
        },
        not_found: false,
        isLoggedIn: false,
        CauseOptions: [],
        Persons: []
    }),
    mounted(){
        this.loadTaskInfo(this.$route.params.id);
        if (this.$store.getters.isLoggedIn === true) {
            this.isLoggedIn = true
        }
        this.loadCauses();
        this.loadPersons();
    },
    computed: {
        causesIsEmpty() {
            if (this.CauseOptions.length === 0) {
                return true;
            } else {
                return false;
            }
        },
        personsIsEmpty() {
            if (this.Persons.length === 0) {
                return true;
            } else {
                return false;
            }
        },
        facttime() {
        if (this.form.Task_Facttime.includes(',')) {
            this.form.Task_Facttime = this.form.Task_Facttime.replace(',', '.');
        }
        }
    },
    methods: {
            loadTaskInfo(id) {
                axios.get('/api/tasks/'+ id)
                .then(res => {
                    if (res.data.status === false) {
                        this.loading = false;
                        this.not_found = true;
                    } else {
                        this.task = res.data;
                        setTimeout(()=> {
                            this.loading = false;
                        }, 100);
                    }
                })
                .catch(err => {
                    this.not_found = true;
                })
            },
            goToIndex: function(){
                this.$router.push('/').catch(()=>{})
            },
            loadCauses(){
                axios.get('/api/causes')
                    .then(res => {
                        if (res.data == "" || res.data == null || !res.data) {
                            setTimeout(() => {
                                this.loading = false;
                            },  50)
                            this.CauseOptions = [];
                            this.not_found = true;
                        } else {
                            this.CauseOptions = res.data;
                            this.not_found = false;
                        }
                    })
            },
            loadPersons() {
                axios.get('/api/persons')
                    .then(res => {
                        if (res.data == "" || res.data == null || !res.data) {
                            UIkit.notification({message: 'Не удалось загрузить сотрудников!', status: 'danger'});
                            this.Persons = [];
                        } else {
                            this.Persons = res.data;
                        }
                    })
            },
            addTaskInfo() {
                if (this.form.Task_Facttime == "" && this.form.Task_Failcause == "" && this.form.Task_Failperson == "") {
                    UIkit.notification({message: 'Ошибка сохранения. Ни одно поле не изменено', status: 'danger'});
                } else {
                    if (this.form.Task_Facttime !== "") {
                        axios.post('/api/tasks/edit', {
                            Task_id: this.task.Task_id,
                            method: "Facttime",
                            Task_Facttime: this.form.Task_Facttime
                        })
                        .then(res => {
                            if (res.data.status == true) {
                                UIkit.notification({message: res.data.message, status: 'success'});
                            } else if (res.data.status == false ) {
                                UIkit.notification({message: res.data.message, status: 'danger'});
                            } else {
                                UIkit.notification({message: "При изменении задачи произошла непредвиденная ошибка", status: 'danger'});
                            }
                        });
                    }
                    if (this.form.Task_Failcause !== "") {
                        axios.post('/api/tasks/edit', {
                            Task_id: this.task.Task_id,
                            method: "Failcause",
                            Task_Failcause: this.form.Task_Failcause
                        })
                        .then(res => {
                            if (res.data.status == true) {
                                UIkit.notification({message: res.data.message, status: 'success'});
                            } else if (res.data.status == false ) {
                                UIkit.notification({message: res.data.message, status: 'danger'});
                            } else {
                                UIkit.notification({message: "При изменении задачи произошла непредвиденная ошибка", status: 'danger'});
                            }
                        });
                    }
                    if (this.form.Task_Failperson !== "") {
                        axios.post('/api/tasks/edit', {
                            Task_id: this.task.Task_id,
                            method: "Failperson",
                            Task_Failperson: this.form.Task_Failperson
                        })
                        .then(res => {
                            if (res.data.status == true) {
                                UIkit.notification({message: res.data.message, status: 'success'});
                            } else if (res.data.status == false ) {
                                UIkit.notification({message: res.data.message, status: 'danger'});
                            } else {
                                UIkit.notification({message: "При изменении задачи произошла непредвиденная ошибка", status: 'danger'});
                            }
                        });
                    }
                    this.loadTaskInfo(this.$route.params.id);
                }
            },
            addTaskInfoAndExit() {
                this.addTaskInfo();
                this.goToIndex();
            }
    }
}
</script>

<style>
.selectSmall {
    display: inline-block;
    width: 500px;
    margin: 0;
    padding: 0px 0px 0px 0px;
}

.labelMax {
    margin: 0 1000px 0 0;
}
</style>