<template>
<div>
    <div class="header">
        
        <v-header></v-header>
    </div>
    <div class="contain">
        <spin v-if="loading"></spin>
        <div v-else-if="!loading && !not_found">
            <div class="itemContain">
                <div class="itemName">
                    <p class="uk-text-lead">{{item.Item_Name}}</p>
                </div>
                <hr class="uk-divider-icon">
                <div uk-grid class="grid" style="display:flex; flex-wrap: wrap;">
                    <div class="itemImage">
                        <div  v-bind:style="styleImage"></div>
                    </div>
                
                    <div class="ItemAbout">
                        <p class="uk-text-muted">Описание:<br>{{item.Item_About}}</p>
                    </div>

                    <div class="itemShopping">
                        <p class="uk-text-large">{{item.Item_Price}} ₽</p>
                        <hr class="uk-divider-icon">
                        <button class="uk-button uk-button-primary" :disabled="isLoggedIn == false" @click="addToBasket">Добавить в корзину</button>
                        <p :hidden="isLoggedIn == true">Для покупки необходимо авторизоваться!</p>
                    </div>
                </div>
                <hr class="uk-divider-icon">
            </div>    
        </div>

        <div uk-alert v-if="not_found">
            <h3>Ошибка 404. Товар не найден!  <a @click="goToIndex"> Вернуться на главную</a></h3>
            
        </div>
    </div>
</div>


</template>

<script>
import Header from '../elements/Header.vue'
import Spin from '../elements/Spin.vue';
import axios from 'axios';

export default {
        components: {
            Header, Spin
        },
        data: () => ({
            loading: true,
            item: [],
            not_found: false,
            styleImage: {
                width: "300px",
                height: "300px",
                backgroundImage: '',
                backgroundSize: "contain",
                backgroundRepeat: "no-repeat",
                backgroundPosition: "50% 50%",
             },
            isLoggedIn: false
        }),
        mounted() {
            this.loadItemInfo(this.$route.params.id);
            if (this.$store.getters.isLoggedIn === true) {
                this.isLoggedIn = true
            }
        },
        methods: {
        loadItemInfo(id) {
            axios.get('/api/items/'+ id)
            .then(res => {
                if (res.data.status === false) {
                    this.loading = false;
                    this.not_found = true;
                } else {
                    if (res.data.Item_ImageLink === "" || res.data.Item_ImageLink === undefined || res.data.Item_ImageLink === null) {
                        this.styleImage.backgroundImage = 'url("https://avatars.mds.yandex.net/i?id=2a0000017a05d5b67a3c3f32ea82c807ae54-4884685-images-thumbs&n=13")';
                        this.item = res.data;
                    } else {
                        this.item = res.data;
                        this.styleImage.backgroundImage = 'url("' + this.item.Item_ImageLink + '")';
                    }
                setTimeout(()=> {
                    this.loading = false;
                }, 100)
                }
            })
            .catch(err => {
                this.not_found = true;
            })
        },
        goToIndex: function(){
            this.$router.push('/').catch(()=>{})
        },
        addToBasket: function(){
            axios.post('/api/basket/add', { User_id: this.$store.getters.GetID, Item_id: this.item.id, token: this.$cookies.get('token')})
            .then(res => {
                if (res.data.status === true) {
                    UIkit.notification({message: res.data.message, status: 'success'});
                } else {
                    UIkit.notification({message: 'Произошла ошибка!', status: 'danger'});
                }
            })
            .catch(err => {
                if (err.response) { 
                    this.$store.dispatch('logout')
                        .then(() => {
                            this.$router.push('/').catch(()=>{})
                        });
                        UIkit.notification({message: 'Сессия истекла!', status: 'danger'});
                } else if (err.request) { 
                    this.$store.dispatch('logout')
                        .then(() => {
                            this.$router.push('/').catch(()=>{})
                        });
                        UIkit.notification({message: 'Сессия истекла!', status: 'danger'});
                } else { 
                // anything else 
                }
            });
        }
        }
        
    }
</script>

<style>
    .itemContain{
        width: 100%;
        height: auto;
    }

    .itemName{
        width: 100%;
        height: auto;
        padding-left: 30px;
        margin-top: 10px;
    }
    
    .grid{
        width: 100%;
        height: 70%;
    }

    .itemImage{
        padding-left: 0px;
        width: 33%;
        min-height: 300px;
        max-height: 300px;
    }
    
    .ItemAbout{
        padding-left: 0px;
        width: 43%;
        min-height: 300px;
        max-height: 300px;
    }
    
    .itemShopping{
        padding-left: 0px;
        width: 23%;
        min-height: 300px;
        max-height: 300px;
        text-align: center;
    }

</style>