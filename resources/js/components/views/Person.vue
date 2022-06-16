<template>
  <div class="wrapper">
    <div class="header">
        <v-header></v-header>
    </div>
    <div class="contain">
        <spin v-if="loading"></spin>
        <div v-else-if="!loading && !not_found">
        <h3>Редактирование сотрудника {{person.Person_Fullname}}</h3>
            <hr class="uk-divider-icon">
            <div class="TaskContain">
                <form class="edit-person" @submit.prevent="" method="POST">
                    <fieldset class="uk-fieldset"> 
                        
                        <div class="uk-margin">
                            <span class="uk-label labelMax">Фамилия сотрудника</span>
                            <input required class="uk-input uk-form-width-large" v-model="form.Person_Surname" type="text" placeholder="Введите фамилию">
                        </div>

                        <hr class="uk-divider-icon">

                        <div class="uk-margin">
                            <span class="uk-label labelMax">Имя</span>
                            <input required class="uk-input uk-form-width-large" v-model="form.Person_Name" type="text" placeholder="Введите имя">
                        </div>

                        <hr class="uk-divider-icon">

                        <div class="uk-margin">
                            <span class="uk-label labelMax">Отчество</span>
                            <input required class="uk-input uk-form-width-large" v-model="form.Person_Secname" type="text" placeholder="Введите отчество">
                        </div>

                        <hr class="uk-divider-icon">

                        <div class="uk-margin">
                            <span class="uk-label labelMax">E-mail</span>
                            <input required class="uk-input uk-form-width-large" v-model="form.Person_Email" type="email" placeholder="Почта сотрудника, например: test@rtmis.ru">
                        </div>

                        <hr class="uk-divider-icon">

                        <div class="uk-margin">
                            <span class="uk-label labelMax">Табельный номер</span>
                            <input required class="uk-input uk-form-width-large" v-model="form.Person_TableId" type="text" placeholder="Табельный номер, например: 404">
                        </div>
                     
                    </fieldset>
                </form>
                <button class="uk-button uk-button-danger" @click="goToPersons">Назад</button>
                <button class="uk-button uk-button-primary" @click="savePersonInfo">Сохранить</button>
                <button class="uk-button uk-button-primary" @click="savePersonInfoAndExit">Сохранить и выйти</button>
            </div>
        </div>

        <div uk-alert v-if="not_found">
            <h3>Ошибка 404. Пользователь не найден!  <a @click="goToPersons">Вернуться к пользователям</a></h3>
            
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
import axios from 'axios';
export default {
 components: {
        Header, Spin, FooterVue
    },
    data: () => ({
        loading: true,
        person: [],
        form: {
            Person_Name: "",
            Person_Secname: "",
            Person_Surname: "",
            Person_Email: "",
            Person_TableId: ""
        },
        not_found: false,
        isLoggedIn: false
    }),
    mounted(){
        this.loadPersonInfo(this.$route.params.id);
        if (this.$store.getters.isLoggedIn === true) {
            this.isLoggedIn = true
        } else {
            this.$router.push('/');
        }
    },
    methods: {
            loadPersonInfo(id) {
                axios.get('/api/persons/'+ id)
                .then(res => {
                    if (res.data.status === false) {
                        this.loading = false;
                        this.not_found = true;
                    } else {
                        this.person = res.data;
                        this.form.Person_Name = res.data.Person_Name;
                        this.form.Person_Secname = res.data.Person_Secname;
                        this.form.Person_Surname = res.data.Person_Surname;
                        this.form.Person_Email = res.data.Person_Email;
                        this.form.Person_TableId = res.data.Person_TableId;
                        setTimeout(()=> {
                            this.loading = false;
                        }, 100)
                    }
                })
                .catch(err => {
                    this.not_found = true;
                })
            },
            goToPersons: function(){
                this.$router.push('/persons').catch(()=>{})
            },
            savePersonInfo() {
                if (this.form.Person_Name == this.person.Person_Name && 
                this.form.Person_Secname == this.person.Person_Secname &&
                this.form.Person_Surname == this.person.Person_Surname &&
                this.form.Person_Email == this.person.Person_Email &&
                this.form.Person_TableId == this.person.Person_TableId
                ) {
                    UIkit.notification({message: 'Ошибка сохранения. Ни одно поле не изменено', status: 'danger'});
                } else {
                    if (this.form.Person_Name !== "") {
                        axios.post('/api/person/edit', {
                            Person_id: this.person.Person_id,
                            method: "name",
                            Person_Name: this.form.Person_Name
                        })
                        .then(res => {
                            if (res.data.status == true) {
                                UIkit.notification({message: res.data.message, status: 'success'});
                            } else if (res.data.status == false ) {
                                UIkit.notification({message: res.data.message, status: 'danger'});
                            } else {
                                UIkit.notification({message: "При изменении имени сотрудника произошла непредвиденная ошибка", status: 'danger'});
                            }
                        });
                    }

                    if (this.form.Person_Secname !== "") {
                        axios.post('/api/person/edit', {
                            Person_id: this.person.Person_id,
                            method: "secName",
                            Person_Secname: this.form.Person_Secname
                        })
                        .then(res => {
                            if (res.data.status == true) {
                                UIkit.notification({message: res.data.message, status: 'success'});
                            } else if (res.data.status == false ) {
                                UIkit.notification({message: res.data.message, status: 'danger'});
                            } else {
                                UIkit.notification({message: "При изменении отчества сотрудника произошла непредвиденная ошибка", status: 'danger'});
                            }
                        });
                    }

                    if (this.form.Person_Surname !== "") {
                        axios.post('/api/person/edit', {
                            Person_id: this.person.Person_id,
                            method: "surName",
                            Person_Surname: this.form.Person_Surname
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

                    if (this.form.Person_Email !== "") {
                        axios.post('/api/person/edit', {
                            Person_id: this.person.Person_id,
                            method: "eMail",
                            Person_Email: this.form.Person_Email
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

                    if (this.form.Person_TableId !== "") {
                        axios.post('/api/person/edit', {
                            Person_id: this.person.Person_id,
                            method: "tableId",
                            Person_TableId: this.form.Person_TableId
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
                    this.loadPersonInfo(this.$route.params.id);
                }
            },
            savePersonInfoAndExit() {
                this.savePersonInfo();
                this.goToPersons();
            }
    }
} 

</script>

<style>
.contain {
    display: block;
    min-height: 100%;
    height: auto;
}
</style>