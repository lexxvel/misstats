<template>
    <div class="uk-card-sprint uk-width-1-2@m">
        
        <div class="uk-card-header">
            <p class="sprintStatsCardName uk-text-center@s uk-text-emphasis uk-text-bolder">{{Sprint_Name}}</p>
        </div>

        <div class="uk-card-body">
            <p class="uk-text-left@s">Задач: {{this.sprintInfo.allTasksCount}}</p>
            <p class="uk-text-left@s">С установленной задержкой: {{this.sprintInfo.failedTasksCount}} ( {{failPersent}} %)</p>
            <p class="uk-text-left@s">Без задержки: {{successCount}} ( {{successPersent}} %)</p>
        </div>

        <div class="uk-card-footer uk-text-center@s">
            <p class="uk-text-center@s uk-text-muted">{{User_Name}}</p>
        </div>     
    </div>
</template>

<script>
export default {
    props: {
        Sprint_id: {
            Type: Number,
            default: 0
        },
        Sprint_Name: {
            Type: String,
            default: "NULL"
        },
        User_Name: {
            Type: String,
            default: "NULL"
        }
    },
    data: () => ({
            loading: true,
            not_found: false,
            sprintInfo: []
    }),
    mounted() {
        this.getSprintStats();
    },
    computed: {
        failPersent() {
            let allTasksCountValue = this.sprintInfo.allTasksCount;
            let failedTasksCountValue = this.sprintInfo.failedTasksCount;
            let persent = (failedTasksCountValue * 100) / allTasksCountValue;
            return persent.toFixed(2);
        },
        successCount() {
            return this.sprintInfo.allTasksCount - this.sprintInfo.failedTasksCount;
        },
        successPersent() {
            return (100 - this.failPersent);
        }
    },
    methods: {
        getSprintStats() {
            axios.post('api/sprint/info', {
                Sprint_id: this.Sprint_id
            }).then(res => {
                        if (res.data.status == false || res.data == "" || res.data == null || !res.data) {
                            setTimeout(() => {
                                this.loading = false;
                            },  50)
                            this.sprintInfo = [];
                            this.not_found = true;
                        } else {
                            this.sprintInfo = res.data;
                            this.not_found = false;
                            setTimeout(() => {
                                this.loading = false;
                            },  50)
                        }
                    })
        }
    }
}
</script>

<style>
.sprintStatsCardName{
    font-size: 12pt;
}

.uk-card-sprint{
    margin: 10px 15px 10px 15px;
    display: block;
    border:1px solid black;
    float: left;
    overflow: hidden;
    border-radius: 7px;
    border-color: #00499c2d;
    background-color: rgba(230, 240, 255, 0.233);
    padding-left:0%; 
    min-width: 465px;
    max-width: 465px;
    min-height: 150px;
    max-height: 150px;
    position:relative;
}
</style>