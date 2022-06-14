<template>
<div>
    <div class="header">
        <v-header></v-header>
    </div>
    <div class="contain">
        <spin v-if="loading"></spin>
        <div v-else-if="!loading && !not_found">
            <h3 class="uk-text-muted">Заказы</h3>
                <order-card v-for="item in orders"
                :key="item.Order_id" 
                :Order_TCost="item.Order_TCost"
                :Order_id="item.Order_id"
                :Order_DT="item.Order_DT"
                :Status="item.Status_Name"
                :Paytype_Name="item.Paytype_Name"
                 />
        </div>

        <div uk-alert v-if="not_found">
            <h3>В заказах пусто!<a @click="goToBasket">В корзину</a></h3>
        </div>
    </div>
</div>
</template>

<script>
import Header from '../elements/Header.vue' 
import Spin from '../elements/Spin.vue';
import OrderCard from '../elements/OrderCard.vue';
import axios from 'axios';
export default {
    components: {
        Header, OrderCard, Spin
    },
    data:() => ({
        loading: true,
        userID: localStorage.getItem('id'),
        orders: [],
        not_found: false,
    }),
    mounted() {
        this.loadOrders()
    },
    created() {
        if (this.$store.getters.isLoggedIn === false) {
            this.$router.push('/');
        };
        
    },
    methods: {
        goToBasket: function(){
            this.$router.push('/basket').catch(()=>{})
        },
        loadOrders() {
            axios.get('/api/orders', {params: {User_id: this.userID, token: this.$cookies.get('token')}})
            .then(res => {
                    if (res.data === '' || res.data === null || !res.data ) {
                        
                    } else {
                        if (res.data.status === false) {
                            this.not_found = true;
                            this.loading = false;
                        } else {
                        this.orders = res.data;
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

        }
    }
}
</script>

<style>

</style>