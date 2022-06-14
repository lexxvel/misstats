<template>
  <div class="ordercarditem">
      <div class="ordercarditem-line">
          <p>-</p>
      </div>
      <div class="ordercarditem-name">
          <router-link :to="{ name: 'item', params: {id: Item_id} }">
            <p>{{Item_Name}}</p>
          </router-link>
      </div>
      <div class="ordercarditem-count">
          <p>× {{Item_Count}}</p>
      </div>
      
  </div>
  
</template>

<script>
import axios from 'axios';
export default {
    props: {
        Item_id:{
            type: Number,
            default: null
        },
        Item_Name:{
            type: String,
            default: 'NULL'
        },
        Item_Count:{
            type: Number,
            default: null
        }
    },
    mounted() {
        this.getItemsByOrderID();
    },
    data: () => ({
        item: []
    }),
    methods: {
        
    }
}
</script>

<style>
    .ordercarditem{
        width: 100%;
        min-height: 30px;
        max-height: 30px;
    }
    .ordercarditem-line{
        padding-left: 3%;
        min-height: 30px;
        max-height: 30px;
        min-width: 4%;
        max-width: 4%;
        float: left;
    }
    .ordercarditem-name{
        min-height: 30px;
        max-height: 30px;
        padding-right: 10px;
        width: auto;
        float: left;
    }
    .ordercarditem-count{
        min-height: 30px;
        max-height: 30px;
        width: 5%;
        float: left;
    }
</style>