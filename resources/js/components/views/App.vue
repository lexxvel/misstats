<template>
<div class="wrapper">
    <div class="header">
        <v-header></v-header>
    </div>
    <div class="contain" uk-panel-scrollable>
        <item-list></item-list>
    </div>
    <div class="footer">
        <footer-vue></footer-vue>
    </div>
</div>
</template>

<script>
import Header from '../elements/Header.vue'
import ItemList from '../elements/ItemList.vue'
import FooterVue from '../elements/FooterBlock.vue'

//import axios from 'axios';

 export default {
        mounted() {
            console.log('Component mounted.');
        },
        components: {
            Header, ItemList, FooterVue
        }
    }
</script>

<style>

</style>
