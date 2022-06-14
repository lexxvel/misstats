<template>
<div>
    <div class="header">
        <v-header></v-header>
    </div>
    <div class="contain">
        <spin v-if="loading"></spin>
        <div v-else-if="!loading && !not_found">
            <h3 class="uk-text-muted">Корзина</h3>
            <item-basket  v-for="item in items" 
                :key="item.Item_id" 
                :name="item.Item_Name"
                :count="item.Item_Count"
                :startPrice="item.Item_Price"
                :price="item.Item_Price"
                :Item_ImageLink="item.Item_ImageLink"
                :id="item.Item_id" />
        </div>
        
        <div class="PayType" v-if="!not_found">
            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                <label><input class="uk-radio" type="radio" name="radio2" checked @click="changePaytype"> Наличными при получении</label>
                <label><input class="uk-radio" type="radio" name="radio2" @click="changePaytype"> По карте</label>
            </div>
        </div>

        <button class="order-btn uk-button uk-button-primary uk-width-1-3" v-if="!not_found" type="button" uk-toggle="target: #modalConfirmBuy" @click="calculateOrderCost" >Заказать</button>
        
        <div uk-alert v-if="not_found">
            <h3 v-if="not_found">В корзине пусто!<a @click="goToIndex">Вернуться на главную</a></h3>
        </div>

        <!-- This is the modal -->
        <div id="modalConfirmBuy" v-if="!not_found" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <h3 class="uk-modal-title">Подтверждение заказа</h3>

                <ul class="uk-list uk-list-divider">
                    <li>Итоговая стоимость:  {{TotalOrderCost}}</li>
                    <li>Тип оплаты:  {{Paytype_Name}}</li>
                </ul>

                <p class="uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">Отмена</button>
                    <button class="uk-button uk-button-primary" type="button" @click="makeOrder">Заказать</button>
                </p>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import ItemBasket from '../elements/ItemBasket.vue'
import Header from '../elements/Header.vue' 
import Spin from '../elements/Spin.vue';
import axios from 'axios';
export default {
    components: {
        Header, Spin, ItemBasket
    },
    data:() => ({
        loading: true,
        userID: localStorage.getItem('id'),
        items: [],
        not_found: false,
        Paytype_id: 1,
        Paytype_Name: "Наличными",
        TotalOrderCost: 0,
        styleImage: {
            width: "300px",
            height: "300px",
            backgroundImage: '',
            backgroundSize: "cover",
            backgroundRepeat: "no-repeat",
            backgroundPosition: "50% 50%",
            }
    }),
    mounted() {
        this.loadItems()
    },
    created() {
        if (this.$store.getters.isLoggedIn === false) {
            this.$router.push('/');
        };
        
    },
    methods: {
        goToIndex: function(){
            this.$router.push('/').catch(()=>{})
        },
        loadItems() {
            axios.get('/api/basket', {params: {User_id: this.userID, token: this.$cookies.get('token')}})
            .then(res => {
                    if (res.data === '' ||res.data === null || !res.data ) {
                        
                    } else {
                        if (res.data.status == false) {
                            this.not_found = true;
                            this.loading = false;
                        } else {
                        this.items = res.data;
                            setTimeout(() => {
                                this.loading = false;
                            },  100)  
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
        makeOrder: function() {
            UIkit.modal(modalConfirmBuy).hide();

            axios.post('/api/orders/make', {User_id: this.userID, Paytype_id: this.Paytype_id, token: this.$cookies.get('token')})
            .then(res => {
                    if (res.data === '' ||res.data === null || !res.data ) {
                        
                    } else {
                        if (res.data.status === false) {
                            UIkit.notification({message: res.data.message, status: 'danger'});
                            this.$router.push('/').catch(()=>{})
                        } else {
                            UIkit.notification({message: res.data.message, status: 'success'});
                            this.$router.push('/orders').catch(()=>{})
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
        changePaytype() {
           if (this.Paytype_id == 1) {
               this.Paytype_id = 2;
               this.Paytype_Name = "По карте";
           } else {
               this.Paytype_id = 1;
               this.Paytype_Name = "Наличными";
           }
        },
        calculateOrderCost(){
            axios.get('/api/basket/getOrderCost/'+this.userID).then(res => {
                    if (res.data === '' || res.data === null || !res.data ) {
                        UIkit.notification({message: 'Произошла ошибка!', status: 'danger'});
                    } else {
                        this.TotalOrderCost = res.data;
                    }

            })
        }
    }
}
</script>

<style>
    .order-btn{
        position: relative;
        left: 50%;
        transform: translate(-50%, 0); 
    }

    .PayType{
        float: left;
        align-content: center;
        width: 100%;
        position: relative;
    }
</style>