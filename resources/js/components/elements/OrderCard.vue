<template>
  <div class="order-card">
      <div class="order-header">
        <div class="order-header-number">
            <p width=50%>Заказ № {{Order_id}}</p>
        </div>
        <div class="order-header-dt">
            <p>Дата/время оформления: {{Order_DT}}</p>
        </div>
      </div>
      <div class="order-body">
          <p class="uk-text-meta">Состав заказа:</p>
          <order-card-item v-for="item in orderItems"
            :key="item.Item_id" 
            :Item_id="item.Item_id"
            :Item_Name="item.Item_Name"
            :Item_Count="item.Item_Count"
          />
      </div>
      <div class="order-info">
        <div class="order-info-cost">
            <p>Общая стоимость: {{Order_TCost}} ₽</p>
        </div>
        <div class="order-info-status">
            <p>Статус: {{Status}}</p>
        </div>
      </div>
  </div>
</template>

<script>
import OrderCardItem from '../elements/OrderCardItem.vue';
export default {
    components: {
        OrderCardItem
    },
    props:{
        Order_id:{
            type: Number,
            default: null
        },
        Order_TCost:{
            type: String,
            default: "NULL"
        },
        Order_DT:{
            type: String,
            default: "NULL"
        },
        Status:{
            type: Number,
            default: null
        },
        Paytype_Name:{
            type: String,
            default: "NULL"
        }
    },
    data:()=> ({
        orderItems: []
    }),
    mounted() {
        this.loadOrderItems()
    },
    methods: {
        loadOrderItems: function() {
            axios.get('/api/orders/items', {params: {Order_id: this.Order_id}})
            .then(res => {
                    if (res.data === '' || res.data === null || !res.data ) {
                        
                    } else {
                        if (res.data.status === false) {

                        } else {
                        this.orderItems = res.data;
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
    .order-card{
        width: 100%;
        height: auto;
        border: 2px solid rgb(240, 240, 240);
        border-radius: 10px;
        margin-bottom: 20px;
        display: inline-block;
        background-color: rgb(252, 252, 252);
    }

    .order-header{
        width: 100%;
        min-height: 25px;
        max-height: 25px;
        background-color: rgb(240, 240, 240);
        border-top: 1px solid rgb(240, 240, 240);
        border-left: 1px solid rgb(240, 240, 240);
        border-right: 1px solid rgb(240, 240, 240);
        border-radius: 10px;
    }

    .order-header-number{
        width: 50%;
        min-height: 25px;
        max-height: 25px;
        border-right: 1px solid rgb(223, 223, 223);
        float: left;
        padding-left: 5px;
    }

    .order-header-dt{
        width: 50%;
        min-height: 25px;
        max-height: 25px;
        border-left: 1px solid rgb(223, 223, 223);
        float: left;
        padding-left: 5px;
    }

    .order-body{
        width: 100%;
        height: auto;
        display: inline-block;
        padding-left: 5px;

    }

    .order-info{
        width: 100%;
        float: left;
        min-height: 25px;
        max-height: 25px;
        background-color: rgb(240, 240, 240);
        border: 1px solid rgb(240, 240, 240);
        border-radius: 10px;
    }

    .order-info-cost{
        width: 50%;
        min-height: 25px;
        max-height: 25px;
        border-right: 1px solid rgb(223, 223, 223);
        float: left;
        padding-left: 5px;
    }

    .order-info-status{
        width: 50%;
        min-height: 25px;
        max-height: 25px;
        border-left: 1px solid rgb(223, 223, 223);
        float: left;
        padding-left: 5px;
    }

    p {
        margin: 0 0 0 0;
    }
</style>