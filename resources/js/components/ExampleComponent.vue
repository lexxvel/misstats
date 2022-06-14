<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>

    <div class ="logo">
      <router-link to="/" value="Главная">
      <img class ="logo" src="/images/logonoframe.png" alt="" href="">
      </router-link>
    </div>
    <nav>
      <ul class="headerUL">
      <li class="headerLI" v-if="!isLoggedIn"><router-link to="/register" class="headerLINK">Регистрация</router-link></li>
      <li class="headerLI" v-if="!isLoggedIn"><router-link to="/login" class="headerLINK">Войти</router-link></li>
      <li class="headerLI" v-if="isLoggedIn"><router-link to="/basket" class="headerLINK">Корзина</router-link></li>
      <li class="headerLI" v-if="isLoggedIn"><a @click="logout" style="color:white;" class="headerLINK">Выйти</a></li>
      </ul>
    </nav>


                </div>
            </div>
        </div>
    </div>








</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
