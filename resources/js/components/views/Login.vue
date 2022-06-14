<template>
    <div>
        <div class="header">
            <v-header></v-header>
        </div>
        <div class="contain">

            <h3>Добро пожаловать на страницу авторизации!</h3>
            <p>Для продолжения введите E-mail и пароль ниже:</p>
            <hr class="uk-divider-icon">
            <form class="login" @submit.prevent="login" method="POST">
                
                <fieldset class="uk-fieldset">
                    
                    <div class="uk-margin">
                        <input required class="uk-input" v-model="form.email" type="email" placeholder="Введите E-mail...">
                    </div>

                    <div class="uk-margin">
                        <input required class="uk-input" v-model="form.password" type="password" placeholder="Введите пароль...">
                    </div>

                    <button class="uk-button uk-button-primary" type="submit">Войти</button>


                    
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
                    email : "",
                    password : ""
                },

            }
        },
        methods: {
            login: function () {
                this.$store.dispatch('login', this.form )
                .then(() => this.$router.push('/'))
                .catch(err => console.log(err));
      }
    }
    }
</script>

<style>

</style>