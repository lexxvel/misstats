<template>
  <div>
    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">  
      <nav class="uk-navbar-container" uk-navbar>
        <router-link to="/" value="Главная">
          <img class ="logo" src="/images/QAstatsLogo.png" alt="" href="">
        </router-link>
        <div class="uk-navbar-right">
          <ul class="uk-navbar-nav">
            <li class="uk-active"><router-link to="/tasks" style="min-height:55px; max-height:55px" v-if="isLoggedIn">Задачи</router-link></li>
            <li><router-link to="/persons" v-if="getRole === '10' || getRole === '2'" style="min-height:55px; max-height:55px">Пользователи</router-link></li>
            <li><router-link to="/sprints" v-if="isLoggedIn" style="min-height:55px; max-height:55px">Спринты</router-link></li>
            <li><router-link to="/graphs" v-if="getRole === '10' || getRole === '2'" style="min-height:55px; max-height:55px">Графики</router-link></li>
            <li class="uk-active" v-if="!isLoggedIn"><router-link to="/login" style="min-height:55px; max-height:55px">Войти</router-link></li>
            <li>
              <div class="uk-navbar-right" v-if="isLoggedIn">
                <ul class="uk-navbar-nav">
                  <li class="uk-active" v-if="isLoggedIn" ><a href="#" style="min-height:55px; max-height:55px">{{GetName}}</a></li>
                  <li><a @click="logout" style="color:red; min-height:55px; max-height:55px">Выход</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div> 

</template>

<script>
import store from '../../store'
  export default {
    computed : {
      isLoggedIn(){ return this.$store.getters.isLoggedIn },
      GetName(){ return this.$store.getters.GetName },
      getRole() { return this.$store.getters.GetRole }
    },
    methods: {
        logout: function () {
        this.$store.dispatch('logout')
        .then(() => {
          this.$router.push('/').catch(()=>{})
        });
        },
    },
  }
</script>

<style>
  .uk-navbar-container{
    height: 55px;
    background-color: aliceblue;
  }

  .uk-navbar-nav{
    height: 55px;
  }

  .uk-active{
    height: 55px;
  }

  .LIheaderDD{
    height: 55px;
  }
</style>