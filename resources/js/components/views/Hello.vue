<template>
    <div class="wrapper">
        <div class="header">
            <v-header></v-header>
        </div>
        <div class="contain">
            <spin v-if="loading"></spin>
            <div class="about" v-else-if="!loading">
            <h3>РТ МИС QA stats</h3>
                <hr class="uk-divider-icon">
                <p class="uk-text-uppercase">Добро пожаловать на главную страницу сервиса QA stats!</p><br>
                <p class="uk-text-normal">Задачи сервиса:</p>
                <ul>
                    <li class="uk-text-normal">Сбор информации о задачах</li>
                    <li class="uk-text-normal">Отображение наглядной информации о причинах задержки исполнения задач</li>
                </ul> <br>
                <p class="uk-text-normal">Цель сервиса:</p><p class="uk-text-bolder">Сбор информации о задержках задач для оптимизации бизнес-процессов компании</p>
                
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
        loading: true
    }),
    mounted(){
        setTimeout(()=> {
            this.loading = false;
        }, 100);
    },
    methods: {
    }
} 

</script>

<style>
.contain {
    display: block;
    min-height: 100%;
    height: auto;
}

.about {
   display: block;
    min-height: 100%;
    height: auto; 
}
</style>