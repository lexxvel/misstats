import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import VueCookies from 'vue-cookies'


Vue.use(Vuex)
Vue.use(VueCookies)

export default new Vuex.Store({
  state: {
    status: localStorage.getItem('status') || '',
    token: $cookies.get('token') || '',
    user: {
      username: localStorage.getItem('username') || '',
      id: localStorage.getItem('id') || '',
      role: localStorage.getItem('role') || '',
    },
  },
  mutations: {
    auth_request(state){
      state.status = 'loading'
    },
    auth_success(state, { token, username, id }){
      state.status = 'success'
      state.token = token
      state.username = username
      state.user.id = id
    },
    auth_error(state){
      state.status = 'error'
    },
    logout(state){
      state.status = ''
      state.token = ''
      state.user.username = ''
      state.user.id = ''
      state.user.role = ''
    },
    login(state, { token, username, id, role }){
      state.status = 'loggedIn'
      state.token = token
      state.user.username = username
      state.user.id = id
      state.user.role = role
    },
  },
  actions: {
    //авторизация из Login.vue
    login({commit}, form ){
    return new Promise((resolve, reject) => {
        commit('auth_request')
        axios.post('/api/login', form)
        .then(resp => {
          if(resp.data.status === true){
            const token = resp.data.remember_token
            const id = resp.data.id
            const username = resp.data.username
            const role = resp.data.User_Role_id
            //localStorage.setItem('token', token)
            localStorage.setItem('username', username)
            localStorage.setItem('status', 'loggedIn')
            localStorage.setItem('id', id)
            localStorage.setItem('role', role)
            $cookies.set('token', token) //УСТАНОВКА ТОКЕНА В КУКИ ВМЕСТО ЛОКАЛСТОР
            axios.defaults.headers.common['Authorization'] = token
            commit('login', { token, username, id, role })
            resolve(resp)
          }else{
            commit('auth_error')
            //localStorage.removeItem('token')
            $cookies.remove('token')
            localStorage.removeItem('username')
            localStorage.removeItem('status')
            localStorage.removeItem('id')
            console.log("Ошибка авторизации")
            UIkit.notification({message: 'Ошибка авторизации! Неверно указан логин или пароль', status: 'danger'})
          }
        })
        .catch(err => {
          commit('auth_error')
          //localStorage.removeItem('token')
          $cookies.remove('token')
          localStorage.removeItem('username')
          localStorage.removeItem('status')
          localStorage.removeItem('id')
          localStorage.removeItem('role')
          reject(err)
        })
      })
    },
      //Выход, вызывается в Header.vue
      logout({commit}){
        return new Promise((resolve, reject) => {
          commit('logout')
          //localStorage.removeItem('token')
          localStorage.removeItem('username')
          localStorage.removeItem('id')
          localStorage.removeItem('role')
          $cookies.remove('token')
          delete axios.defaults.headers.common['Authorization']
          resolve()
        })
       }
  },
  getters: {
    isLoggedIn: state => !!state.token,
    AuthStatus: state => state.status,
    GetName: state => state.user.username,
    GetID: state => state.user.id,
    GetRole: state => state.user.role,
  }
})
