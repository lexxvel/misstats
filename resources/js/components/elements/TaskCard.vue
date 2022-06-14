<template>
  <div class="task-card">
    <div class="task-header">
        <div class="task-header-number">
            <div class="sectionTextWValueSmall">
                <a v-bind:href="taskLink"><p> Задача: {{Task_Number}}</p></a>
            </div>
            <a href="" v-if="Task_Failcause == 'Не указана' || Task_Failperson === 101 || Task_Facttime === null" @click="openTaskEdit()"><img class="sectionBtnSmall" src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ficons.iconarchive.com%2Ficons%2Fcustom-icon-design%2Fflatastic-1%2F512%2Fedit-icon.png&f=1&nofb=1" alt="">
            </a>
             </div>
        <div class="task-header-plan">
            <p>План: {{Task_Plantime}}</p>
        </div>
        <div class="task-header-fact">
            <p v-if="!alertTask">Факт: {{Task_Facttime}}</p>
            <p v-if="alertTask" style="color: rgb(255, 0, 0);">Факт: {{Task_Facttime}}</p>
        </div>
    </div>
    <div class="task-fail">
        <div class="task-fail-cause">
            <p v-if="(!alertTask && Task_Failcause !== 'Не указана') || (alertTask && Task_Failcause !== 'Не указана') || (!alertTask && Task_Failcause === 'Не указана')">Причина: {{Task_Failcause}}</p>
            <p v-if="alertTask && Task_Failcause === 'Не указана'" class="alertTask">Причина: {{Task_Failcause}}</p>    
        </div>
        <div class="task-fail-person">
            <p v-if="(!alertTask && Task_Failperson !== 101) || (alertTask && Task_Failperson !== 101) || (!alertTask && Task_Failperson === 101)">Виновный: {{Task_FailpersonFullName}}</p>
            <p v-if="alertTask && Task_Failperson === 101" class="alertTask">Виновный: {{Task_FailpersonFullName}}</p>
        </div>
    </div>

  </div>

</template>

<script>
import { throwStatement } from '@babel/types';

export default {
    components: {
        
    },
    props:{
        Task_id:{
            type: Number,
            default: null
        },
        Task_Number:{
            type: String,
            default: "NULL"
        },
        Task_Plantime:{
            type: Number,
            default: 0
        },
        Task_Facttime:{
            type: Number,
            default: 0
        },
        Task_Failcause:{
            type: String,
            default: "NULL"
        },
        Task_Failperson:{
            type: Number,
            default: null
        },
        Task_FailpersonFullName:{
            type: String,
            default: ""
        }
    },
    data:()=> ({
        taskLink:{
            type: String,
            default: "NULL" 
        },
        Value:{ 
            type: String,
            default: "NULL"
            },
        Type:{
            type: String,
            default: "NULL"
        },
        Task_idForLink: "",
        dif: 0,
        alertTask: false
    }),
    mounted() {
        this.taskLink = "https://jira.is-mis.ru/browse/PROMEDWEB-"+this.Task_Number;
        this.Task_idForLink = this.Task_id;

        this.checkTimeDifference();
    },
    methods: {
        openTaskEdit() {
            this.$router.push('/task/'+this.Task_id).catch(()=>{})
        },

        checkTimeDifference() {
            this.dif = this.Task_Facttime / this.Task_Plantime;
            if (this.dif > 1.5) {
                this.alertTask = true;
            }
        }
    },
}
</script>

<style>
    .task-card{
        width: 100%;
        height: auto;
        border: 2px solid rgb(240, 240, 240);
        border-radius: 10px;
        margin-bottom: 20px;
        display: inline-block;
        background-color: rgb(252, 252, 252);
    }

    .task-header{
        width: 100%;
        min-height: 25px;
        max-height: 25px;
        background-color: rgb(240, 240, 240);
        border-top: 1px solid rgb(240, 240, 240);
        border-left: 1px solid rgb(240, 240, 240);
        border-right: 1px solid rgb(240, 240, 240);
        border-radius: 10px;
    }

    .task-header-number{
        width: 33%;
        min-height: 25px;
        max-height: 25px;
        border-right: 1px solid rgb(223, 223, 223);
        float: left;
        padding-left: 5px;
    }

    .task-header-plan{
        width: 33%;
        min-height: 25px;
        max-height: 25px;
        border-left: 1px solid rgb(223, 223, 223);
        float: left;
        padding-left: 5px;
    }

    .task-header-fact{
        width: 34%;
        min-height: 25px;
        max-height: 25px;
        border-left: 1px solid rgb(223, 223, 223);
        float: left;
        padding-left: 5px;
    }

    .task-fail{
        width: 100%;
        float: left;
        min-height: 25px;
        max-height: 25px;
        background-color: rgb(240, 240, 240);
        border: 1px solid rgb(240, 240, 240);
        border-radius: 10px;
    }

    .task-fail-cause{
        width: 50%;
        min-height: 25px;
        max-height: 25px;
        border-right: 1px solid rgb(223, 223, 223);
        float: left;
        padding-left: 5px;
    }

    .task-fail-person{
        width: 50%;
        min-height: 25px;
        max-height: 25px;
        border-left: 1px solid rgb(223, 223, 223);
        float: left;
        padding-left: 5px;
    }
    .sectionTextWValue{
        width: 95%;
        float: left;
    }

    .sectionTextWValueSmall{
        width: 92%;
        float: left;
    }
    
    .sectionBtnSmall{
        width: 8%;
        float: left;
        background-color: none;
        min-height: 25px;
        max-height: 25px;
        margin: 0 0 0 0;
    }
    
    .alertTask {
        background-color: rgba(255, 209, 209, 0.389);
    }

    p {
        margin: 0 0 0 0;
    }
</style>