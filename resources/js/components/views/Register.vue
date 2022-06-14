<template>
    <div>
        <div class="header">
            <v-header></v-header>
        </div>
        <div class="contain">
            <h3>Добро пожаловать на страницу регистрации!</h3>
            <p>Для продолжения заполните поля и нажмите "Зарегистрироваться"</p>
            <hr class="uk-divider-icon">
            <form class="registration" @submit.prevent="register" method="POST">
                
                <fieldset class="uk-fieldset">
                    
                    <div class="uk-margin">
                        <input required class="uk-input" v-model="form.name" type="text" placeholder="Введите ваше имя">
                    </div>

                    <div class="uk-margin">
                        <input required class="uk-input" v-model="form.surname" type="text" placeholder="Введите вашу фамилию">
                    </div>

                    <div class="uk-margin">
                        <input required class="uk-input" v-model="form.secname" type="text" placeholder="Введите ваше отчество">
                    </div>

                    <div class="uk-margin">
                        <input required class="uk-input" v-model="form.email" type="email" placeholder="Введите e-mail...">
                    </div>

                    <div class="uk-margin">
                        <input required class="uk-input" v-model="form.password" type="password" placeholder="Введите пароль...">
                    </div>

                    <button class="uk-button uk-button-primary" type="submit">Зарегистрироваться</button>
                </fieldset>
            </form>
        </div>
    </div>
</template>

<script>
import Header from '../elements/Header.vue'
export default {
        mounted() {
            console.log('Component mounted.');
        },
        created() {
            if (this.$store.getters.isLoggedIn === true) {
                this.$router.push('/');
            }
        },
        components: {
            Header
        },
        data(){
            return {
                form: {
                    name: "",
                    surname: "",
                    secname: "",
                    email : "",
                    password : ""
                },

            }
        },
        methods: {
            register: function () {
                this.$store.dispatch('register', this.form )
                .then(() => this.$router.push('/login'))
                .catch(err => console.log(err));
      }
    }
    }
</script>

<style>

</style>