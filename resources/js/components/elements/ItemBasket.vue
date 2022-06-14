<template>
<div class="ItemBasket" :hidden="outStaff">
    <router-link :to="{ name: 'item', params: {id: id} }">
    <div class="ItemBasketPhoto">
        <div v-bind:style="styleImage">
        </div>
    </div>
    </router-link>
    <div class="ItemBasketTitle">
        <p class="uk-text-left@s uk-text-emphasis">{{name}}</p>
    </div>
    <div class="ItemBasketPrice" >
        <p class="uk-text-meta">Итоговая цена:</p>
        <p class="uk-text-bolder"> {{price}} ₽</p>
    </div>
    <div class="ItemBasketCount" >
        <div class="ItemBasketCountMinus">
            <button class="uk-button uk-button-default uk-button-small" style="margin-bottom: 0px; margin-top: 10px; width: 40px;" @click="decreaseCount">-</button>
        </div>
        <div class="ItemBasketCountCount">
            <p class="uk-text-center@s uk-text-emphasis" style="margin-bottom: 0px; margin-top: 0px;">Количество:</p>
            <p class="uk-text-center@s uk-text-emphasis" style="margin-bottom: 0px; margin-top: 0px; align:left">{{count}} шт</p>
        </div>
        <div class="ItemBasketCountPlus">
            <button class="uk-button uk-button-default uk-button-small" style="margin-bottom: 0px; margin-top: 10px; width: 40px;" @click="increaseCount">+</button>
        </div>
        
        
    </div>
</div>
</template>

<script>
import axios from 'axios';
export default {
        props:{
            id:{
                type: Number,
                default: null
            },
            name:{
                type: String,
                default: "NULL"
            },
            startPrice:{
                type: Number,
                default: null
            },
            price:{
                type: Number,
                default: null
            },
            count:{
                type: Number,
                default: null
            }
            ,
            Item_ImageLink:{
                type: String,
                default: "https://avatars.mds.yandex.net/i?id=2a0000017a05d5b67a3c3f32ea82c807ae54-4884685-images-thumbs&n=13"
            }
        },
        data: () => ({
            styleImage: {
                width: "100px",
                height: "100px",
                backgroundImage: '',
                backgroundSize: "contain",
                backgroundRepeat: "no-repeat",
                backgroundPosition: "50% 50%"
             },
            outStaff: false
        }),
        created(){
            if (this.Item_ImageLink === "" || this.Item_ImageLink === undefined || this.Item_ImageLink === null) {
                this.styleImage.backgroundImage = 'url("https://avatars.mds.yandex.net/i?id=2a0000017a05d5b67a3c3f32ea82c807ae54-4884685-images-thumbs&n=13")';
            } else {
                this.styleImage.backgroundImage = 'url("' + this.Item_ImageLink + '")';
            };
            this.price = this.price*this.count;
        },
        methods: {
            increaseCount: function(){
                axios.post('/api/basket/control', {method: 'increase-count', User_id: this.$store.getters.GetID, Item_id: this.id, token: this.$cookies.get('token')})
                .then(res => {
                    if (res.data === '' ||res.data === null || !res.data ) {
                        
                    } else {
                        if (res.data.status === false) {
                            UIkit.notification({message: res.data.message, status: 'danger'});
                        } else {
                            this.count += 1;
                            this.price = this.startPrice*this.count;
                        }
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
            },
            decreaseCount: function(){
                axios.post('/api/basket/control', {method: 'decrease-count', User_id: this.$store.getters.GetID, Item_id: this.id, token: this.$cookies.get('token')})
                .then(res => {
                    if (res.data === '' ||res.data === null || !res.data ) {
                        
                    } else { 
                        if (res.data.status === false) {
                            UIkit.notification({message: res.data.message, status: 'danger'})
                        } else {
                            if (this.count > 1) {
                                this.count -= 1;
                                this.price = this.startPrice*this.count;
                            } else {
                                this.count -= 1;
                                this.outStaff = true
                                UIkit.notification({message: res.data.message, status: 'warning'});
                                this.$router.push('/');
                            }
                        }
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
        },
        name: "ItemBasket"
    }
</script>

<style>
    .ItemBasket{
        width: 100%;
        min-height: 100px;
        max-height: 100px;
        display: block;
        border: 1px solid black;
        float: left;
        overflow: hidden;
        border-radius: 5px;
        border-color: #00499c2d;
        margin-bottom: 5px;
    }
    .ItemBasketPhoto{
        float: left;
        height: 100%;
        min-width: 10%;
        max-width: 10%;
        margin-right: 1%;
    }
    .ItemBasketTitle{
        float:right;
        min-width: 89%;
        max-width: 89%;
        min-height: 25px;
        max-height: 25px;
    }

    .ItemBasketPrice{
        min-width: 39%;
        max-width: 39%;
        align-content: right;
        min-height: 75px;
        max-height: 75px;
        float:right;
        text-align: center;
        border-left: 1px solid black;
        border-top: 1px solid black;
        border-radius: 1px;
        border-color: #00499c2d;
    }

    .ItemBasketCount{
        min-width: 50%;
        max-width: 50%;
        align-content: center;
        min-height: 75px;
        max-height: 75px;
        float:right;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    .ItemBasketCountMinus{
        width: 33%;
        text-align: right;
    }

    .ItemBasketCountCount{
        flex-basis: 33%;
        flex-grow: 1;
    }

    .ItemBasketCountPlus{
        flex-basis: 33%;
        flex-grow: 2;
    }
</style>