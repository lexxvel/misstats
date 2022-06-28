<template>

<div>
    <div class="filterPanel">
        <div>
            <p class="uk-text-uppercase uk-text-meta">Категория:  </p>
        </div>
        <div>
            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                <label><input class="uk-radio" id="radioMain" type="radio" name="radio2" @click="changePreferCat(0)" checked> Все</label>
                <label><input class="uk-radio" type="radio" name="radio2" @click="changePreferCat(1)"> Без итога</label>
                <label><input class="uk-radio" type="radio" name="radio2" @click="changePreferCat(2)"> Проблемные</label>
                <label><input class="uk-radio" type="radio" name="radio2" @click="changePreferCat(3)"> Не проблемные</label>
            </div>
            <button class="BtnFilterAccept uk-button uk-button-primary uk-button-small" @click="loadTasksByCat">Применить</button>
        </div>
    </div>
 
        <spin v-if="loading"></spin>
        <div v-else-if="!loading && !not_found">
            <h3 class="uk-text-muted">Задачи:</h3>
            <button id="modalBtn" class="uk-button uk-button-primary" href="#modal-addTask-center" uk-toggle>Добавить</button>
                <task-card v-for="task in tasks"
                :key="task.Task_id"
                :Task_id="task.Task_id"
                :Task_Number="task.Task_Number"
                :Task_Plantime="task.Task_Plantime"
                :Task_Facttime="task.Task_Facttime"
                :Task_Failcause="task.Cause_Name"
                :Task_Failperson="task.Task_Failperson"
                :Task_FailpersonFullName="task.Person_Fullname"
                :Sprint_Name="task.Sprint_Name"
                 />
        </div>

        <div id="modal-addTask-center" class="uk-flex-top" uk-modal>
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                <form class="add-task" @submit.prevent="addTask" method="POST">
                    <fieldset class="uk-fieldset">
                        <div class="uk-margin">
                            <input required class="uk-input" v-model="form.Task_Number" type="text" placeholder="Номер задачи, например 101101">
                        </div>
                        
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-select">Спринт</label>
                            <div class="uk-form-controls">
                                <select required v-model="form.Task_SprintName" class="uk-select" id="form-horizontal-select">
                                    <options v-for="sprint in Sprints"
                                    :key="sprint.Sprint_id"
                                    :Option="sprint.Sprint_Name"
                                    />
                                </select>
                            </div>
                        </div>

                        <div class="uk-margin">
                            <input required class="uk-input" v-model="form.Task_Plantime" type="text" placeholder="Оценка трудозатрат">
                        </div>

                        <div class="uk-margin">
                            <input class="uk-input" v-model="form.Task_Facttime" type="text" placeholder="Фактические трудозатраты">
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-select">Причина задержки</label>
                            <div class="uk-form-controls">
                                <select v-model="form.Task_Failcause" class="uk-select" id="form-horizontal-select">
                                    <options v-for="option in CauseOptions"
                                    :key="option.Cause_id"
                                    :Option="option.Cause_Name"
                                    />
                                </select>
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-select">Виновный</label>
                            <div class="uk-form-controls">
                                <select v-model="form.Task_Failperson" class="uk-select" id="form-horizontal-select">
                                    <options v-for="person in Persons"
                                    :key="person.Person_id"
                                    :Option="person.Person_Fullname"
                                    />
                                </select>
                            </div>
                        </div>

                        <button class="uk-button uk-button-default uk-modal-close" type="button" @click="clearAddTaskForm()">Отмена</button>
                        <button class="uk-button uk-button-primary" type="submit">Сохранить</button>
                    </fieldset>
                </form>
            </div>
        </div>

        <div uk-alert v-if="not_found && !loading">
            <h3>Задач ещё не добавлены!</h3>
        </div>

</div>
    
</template>

<script>
import Spin from './Spin.vue';
import TaskCard from './TaskCard.vue';
import Options from './Options.vue';
import axios from 'axios';
//import { resolveSoa } from 'dns';

export default {
    components: {
    Spin,
    TaskCard,
    Options
},
    data: () => ({
            loading: true,
            not_found: true,
            preferCategory: 0,
            tasks: [],
            form: {
                Task_Number : "",
                Task_Plantime : "",
                Task_Facttime : "",
                Task_Failcause : "",
                Task_Failperson : "",
                Task_SprintName: ""
            },
            CauseOptions: [], 
            Persons: [],
            Sprints: [],
            filteredTasks: [],
            tasksLenght: 0
    }),
    computed: {
    facttime() {
      if (this.form.Task_Facttime.includes(',')) {
        this.form.Task_Facttime = this.form.Task_Facttime.replace(',', '.');
      }
    },
    plantime() {
      if (this.form.Task_Plantime.includes(',')) {
        this.form.Task_Plantime = this.form.Task_Plantime.replace(',', '.');
      }
    },
    Lenght() {
        this.tasksLenght = this.tasks.length;
        if (tasksLenght / 100 >= 1) {

        }
    },
    User_id() { return this.$store.getters.GetID }
    },
    methods: {
        loadTasks: async function() {
            this.loading = true;
            await axios.post('/api/tasks', {
                User_id: this.User_id
            })
            .then(res => {
                if (res.data.status == false || res.data == "" || res.data == null || !res.data) {
                    setTimeout(() => {
                        this.loading = false;
                    },  50)
                    this.tasks = [];
                    this.not_found = true;
                } else {
                    this.tasks = res.data;
                    this.not_found = false;
                    setTimeout(() => {
                        this.loading = false;
                    },  50)
                }
            })
        },
        loadTasksByCat() {
            if (this.preferCategory == 0) {
                this.loadTasks();
            } else if (this.preferCategory == 1) {
                this.loading = true;
                axios.post('/api/tasks/byCat', { category: this.preferCategory, User_id: this.User_id })
                .then(res => {         
                if (res.data.status == false || res.data == "" || res.data == null || !res.data) {
                    this.tasks = [];
                    this.not_found = true;
                } else {
                    this.tasks = res.data;
                }
                setTimeout(() => {
                    this.loading = false;
                },  200)
            });
            } else {
                if (this.preferCategory == 2) { //проблемные задачи
                    this.loading = true;
                    axios.get('/api/tasks')
                    .then(res => {
                        if (res.data.status == false || res.data == "" || res.data == null || !res.data) {
                            setTimeout(() => {
                                this.loading = false;
                            },  50)
                            this.tasks = [];
                            this.not_found = true;
                        } else {
                            this.filteredTasks = res.data;
                            this.tasks = [];
                            for (const el of this.filteredTasks) {
                                if (el.Task_Facttime / el.Task_Plantime >= 1.5 && el.Task_Facttime !== null) {
                                    this.tasks.push(el);
                                }
                            }
                            this.not_found = false;
                            setTimeout(() => {
                                this.loading = false;
                            },  50)
                        }
                    })
                } else if (this.preferCategory == 3) { //не проблемные задачи
                    this.loading = true;
                    axios.get('/api/tasks')
                    .then(res => {
                        if (res.data.status == false || res.data == "" || res.data == null || !res.data) {
                            setTimeout(() => {
                                this.loading = false;
                            },  50)
                            this.tasks = [];
                            this.not_found = true;
                        } else {
                            this.filteredTasks = res.data;
                            this.tasks = [];
                            for (const el of this.filteredTasks) {
                                if (el.Task_Facttime / el.Task_Plantime < 1.5 && el.Task_Facttime !== null) {
                                    this.tasks.push(el);
                                }
                            }
                            this.not_found = false;
                            setTimeout(() => {
                                this.loading = false;
                            },  50)
                        }
                    })
                    /*this.filteredTasks = this.tasks;
                    this.tasks = [];
                    for (const el of this.filteredTasks) {
                        if (el.Task_Facttime / el.Task_Plantime < 1.5 && el.Task_Facttime !== null) {
                            this.tasks.push(el);
                        }
                    }*/
                } else {
                    //
                }
            }
        }, 
        changePreferCat (id) {
            this.preferCategory = id;
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
        loadSprints() {
            axios.post('/api/sprints', {
                'User_id': this.User_id
            }).then(res => {
                if (res.data.status == false ) {
                     this.Sprints = [];
                    UIkit.notification({message: res.data.message, status: 'danger'});
                } else if (res.data){
                    this.Sprints = res.data;
                } else {
                    UIkit.notification({message: "При загрузке спринтов произошла ошибка!", status: 'danger'});
                }
            });
        },
        clearAddTaskForm(){
             this.form.Task_Number = "";
             this.form.Task_Plantime = "";
             this.form.Task_Facttime = "";
             this.form.Task_Failcause = "";
             this.form.Task_Failperson = "";
             this.form.Task_SprintName = "";
        },
        addTask: function () {
            axios.post('/api/tasks/add', {
                Task_Number: this.form.Task_Number,
                Task_Plantime: this.form.Task_Plantime,
                Task_Facttime: this.form.Task_Facttime,
                Task_Failcause: this.form.Task_Failcause,
                Task_Failperson: this.form.Task_Failperson,
                Task_SprintName: this.form.Task_SprintName
                })
            .then(res => {
                if (res.data.status == true) {
                    UIkit.notification({message: res.data.message, status: 'success'});
                } else if (res.data.status == false ) {
                    UIkit.notification({message: res.data.message, status: 'danger'});
                } else {
                    UIkit.notification({message: "При добалении задачи произошла непредвиденная ошибка", status: 'danger'});
                }
            });
            UIkit.modal("#modal-addTask-center").hide();
            this.clearAddTaskForm();
            if (this.preferCategory === 0) {
                this.loadTasks();
            } else {
                this.loadTasksByCat();
            }
            
            
        }
    },
    mounted() {
        console.log("logged in: " + this.$store.getters.isLoggedIn);
            if (this.$store.getters.isLoggedIn === false) {
            this.$router.push('/');
            };
        this.loadTasks();
        this.loadCauses();
        this.loadPersons();
        this.loadSprints();
    },
    computed: {
        User_id() { return this.$store.getters.GetID }
    }
}

</script>

<style>
</style>